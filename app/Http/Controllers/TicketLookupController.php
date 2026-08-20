<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TicketLookupController extends Controller
{
    public function qr(Ticket $ticket): Response
    {
        $result = $this->generateQr($ticket);

        return response($result, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function downloadQr(Ticket $ticket): Response
    {
        $card = $this->generateCard($ticket);

        return response($card, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="tiket-' . $ticket->uuid . '.svg"',
        ]);
    }

    private function generateCard(Ticket $ticket): string
    {
        $qr = base64_encode($this->generateQr($ticket));
        $uuid = htmlspecialchars($ticket->uuid, ENT_QUOTES, 'UTF-8');

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="768" height="768" viewBox="0 0 768 768">
  <rect width="768" height="768" fill="#ffffff"/>
  <rect x="24" y="24" width="720" height="720" rx="16" fill="#ffffff" stroke="#96b2cc" stroke-width="2"/>
  <text x="384" y="84" text-anchor="middle" font-family="Arial, sans-serif" font-size="32" font-weight="700" fill="#0b141c">TIKET PELAYANAN</text>
  <line x1="222" y1="116" x2="366" y2="116" stroke="#0b3558" stroke-width="2"/>
  <circle cx="384" cy="116" r="6" fill="#0b3558"/>
  <line x1="402" y1="116" x2="546" y2="116" stroke="#0b3558" stroke-width="2"/>
  <text x="384" y="145" text-anchor="middle" font-family="Arial, sans-serif" font-size="18" fill="#0b141c">Scan QR Code untuk melihat detail layanan Anda</text>
  <image x="234" y="190" width="300" height="300" href="data:image/svg+xml;base64,{$qr}"/>
  <line x1="130" y1="610" x2="332" y2="610" stroke="#96b2cc" stroke-width="2"/>
  <line x1="436" y1="610" x2="638" y2="610" stroke="#96b2cc" stroke-width="2"/>
  <text x="384" y="622" text-anchor="middle" font-family="Arial, sans-serif" font-size="18" fill="#0b3558">UUID</text>
  <text x="384" y="681" text-anchor="middle" font-family="Arial, sans-serif" font-size="22" fill="#0b141c">{$uuid}</text>
</svg>
SVG;
    }

    private function generateQr(Ticket $ticket): string
    {
        $qrCode = new QrCode(
            data: $ticket->uuid,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 16,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(11, 53, 88),
            backgroundColor: new Color(255, 255, 255),
        );
                $svg = (new SvgWriter())->write($qrCode)->getString();
                $logoPath = public_path('images/logo-bengkulu-selatan.png');

                if (! is_file($logoPath)) {
                        return $svg;
                }

                $logo = base64_encode((string) file_get_contents($logoPath));
                $overlay = <<<SVG
    <rect x="119" y="119" width="62" height="62" rx="10" fill="#ffffff"/>
    <image x="123" y="123" width="54" height="54" preserveAspectRatio="xMidYMid meet" href="data:image/png;base64,{$logo}"/>
SVG;

                return str_replace('</svg>', $overlay . "\n</svg>", $svg);
    }

    public function __invoke(Request $request): View
    {
        $uuid = trim((string) $request->query('uuid', ''));
        $ticket = null;
        $canViewFollowUps = false;

        if ($uuid !== '') {
            $query = Ticket::query()
                ->with('service.category')
                ->where('uuid', $uuid);

            $user = $request->user();
            $ticket = $query->first();

            $canViewFollowUps = $ticket && $user && (
                $ticket->user_id === $user->id || $user->hasPermission('admin.access')
            );

            if ($canViewFollowUps) {
                $ticket->load(['followUps' => fn ($followUpQuery) => $followUpQuery->where('is_public', true)->latest()]);
            }
        }

        return view('tickets.lookup', [
            'uuid' => $uuid,
            'ticket' => $ticket,
            'canViewFollowUps' => $canViewFollowUps,
            'showCreatedModal' => $ticket && session('ticket_created_uuid') === $ticket->uuid,
            'searched' => $uuid !== '',
        ]);
    }

    public function downloadFollowUpFile(Ticket $ticket, int $followUp): Response
    {
        $user = request()->user();
        abort_unless(
            $ticket->user_id === $user?->id || $user?->hasPermission('admin.access'),
            403
        );

        $followUp = $ticket->followUps()
            ->where('is_public', true)
            ->findOrFail($followUp);

        return Storage::disk('local')->response($followUp->file_path, $followUp->file_name, [
            'Content-Type' => $followUp->file_mime,
        ]);
    }
}
