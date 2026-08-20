-- ============================================================
-- PostgreSQL Migration Script for Layanan Kominfo Database
-- Generated from Laravel Migrations
-- ============================================================

-- 1. Create Users Table
CREATE TABLE IF NOT EXISTS users (
  id BIGSERIAL PRIMARY KEY,
  organization_id BIGINT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  is_active BOOLEAN NOT NULL DEFAULT true,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
CREATE INDEX idx_users_organization_id ON users(organization_id);
CREATE INDEX idx_users_is_active ON users(is_active);

-- 2. Create Password Reset Tokens Table
CREATE TABLE IF NOT EXISTS password_reset_tokens (
  email VARCHAR(255) NOT NULL PRIMARY KEY,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL
);

-- 3. Create Sessions Table
CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(255) NOT NULL PRIMARY KEY,
  user_id BIGINT NULL,
  ip_address VARCHAR(45) NULL,
  user_agent TEXT NULL,
  payload TEXT NOT NULL,
  last_activity INTEGER NOT NULL
);
CREATE INDEX idx_sessions_user_id ON sessions(user_id);
CREATE INDEX idx_sessions_last_activity ON sessions(last_activity);

-- 4. Create Cache Table
CREATE TABLE IF NOT EXISTS cache (
  key VARCHAR(255) NOT NULL PRIMARY KEY,
  value TEXT NOT NULL,
  expiration INTEGER NOT NULL
);
CREATE INDEX idx_cache_expiration ON cache(expiration);

-- 5. Create Cache Locks Table
CREATE TABLE IF NOT EXISTS cache_locks (
  key VARCHAR(255) NOT NULL PRIMARY KEY,
  owner VARCHAR(255) NOT NULL,
  expiration INTEGER NOT NULL
);
CREATE INDEX idx_cache_locks_expiration ON cache_locks(expiration);

-- 6. Create Jobs Table
CREATE TABLE IF NOT EXISTS jobs (
  id BIGSERIAL PRIMARY KEY,
  queue VARCHAR(255) NOT NULL,
  payload TEXT NOT NULL,
  attempts SMALLINT NOT NULL,
  reserved_at INTEGER NULL,
  available_at INTEGER NOT NULL,
  created_at INTEGER NOT NULL
);
CREATE INDEX idx_jobs_queue ON jobs(queue);

-- 7. Create Job Batches Table
CREATE TABLE IF NOT EXISTS job_batches (
  id VARCHAR(255) NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  total_jobs INTEGER NOT NULL,
  pending_jobs INTEGER NOT NULL,
  failed_jobs INTEGER NOT NULL,
  failed_job_ids TEXT NOT NULL,
  options TEXT NULL,
  cancelled_at INTEGER NULL,
  created_at INTEGER NOT NULL,
  finished_at INTEGER NULL
);

-- 8. Create Failed Jobs Table
CREATE TABLE IF NOT EXISTS failed_jobs (
  id BIGSERIAL PRIMARY KEY,
  uuid VARCHAR(255) NOT NULL UNIQUE,
  connection TEXT NOT NULL,
  queue TEXT NOT NULL,
  payload TEXT NOT NULL,
  exception TEXT NOT NULL,
  failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 9. Create Organizations Table
CREATE TABLE IF NOT EXISTS organizations (
  id BIGSERIAL PRIMARY KEY,
  parent_id BIGINT NULL,
  code VARCHAR(255) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL,
  is_active BOOLEAN NOT NULL DEFAULT true,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  CONSTRAINT fk_organizations_parent_id FOREIGN KEY (parent_id) REFERENCES organizations(id) ON DELETE SET NULL
);
CREATE INDEX idx_organizations_type ON organizations(type);
CREATE INDEX idx_organizations_is_active ON organizations(is_active);

-- 10. Add Foreign Key to Users Table (organization_id)
ALTER TABLE users 
ADD CONSTRAINT fk_users_organization_id 
FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE SET NULL;

-- 11. Create Roles Table
CREATE TABLE IF NOT EXISTS roles (
  id BIGSERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  code VARCHAR(255) NOT NULL UNIQUE,
  description TEXT NULL,
  is_active BOOLEAN NOT NULL DEFAULT true,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
CREATE INDEX idx_roles_is_active ON roles(is_active);

-- 12. Create Permissions Table
CREATE TABLE IF NOT EXISTS permissions (
  id BIGSERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  code VARCHAR(255) NOT NULL UNIQUE,
  module VARCHAR(255) NOT NULL,
  description TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
CREATE INDEX idx_permissions_module ON permissions(module);

-- 13. Create Permission Role Table
CREATE TABLE IF NOT EXISTS permission_role (
  permission_id BIGINT NOT NULL,
  role_id BIGINT NOT NULL,
  PRIMARY KEY (permission_id, role_id),
  CONSTRAINT fk_permission_role_permission_id FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
  CONSTRAINT fk_permission_role_role_id FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- 14. Create Role User Table
CREATE TABLE IF NOT EXISTS role_user (
  role_id BIGINT NOT NULL,
  user_id BIGINT NOT NULL,
  PRIMARY KEY (role_id, user_id),
  CONSTRAINT fk_role_user_role_id FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
  CONSTRAINT fk_role_user_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 15. Create Service Categories Table
CREATE TABLE IF NOT EXISTS service_categories (
  id BIGSERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  code VARCHAR(255) NOT NULL UNIQUE,
  description TEXT NULL,
  image_path VARCHAR(255) NULL,
  is_active BOOLEAN NOT NULL DEFAULT true,
  sort_order INTEGER NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
CREATE INDEX idx_service_categories_is_active ON service_categories(is_active);
CREATE INDEX idx_service_categories_sort_order ON service_categories(sort_order);

-- 16. Create Services Table
CREATE TABLE IF NOT EXISTS services (
  id BIGSERIAL PRIMARY KEY,
  category_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  code VARCHAR(255) NOT NULL UNIQUE,
  description TEXT NULL,
  sla_hours INTEGER NOT NULL DEFAULT 24,
  is_active BOOLEAN NOT NULL DEFAULT true,
  sort_order INTEGER NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  CONSTRAINT fk_services_category_id FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE RESTRICT
);
CREATE INDEX idx_services_is_active ON services(is_active);
CREATE INDEX idx_services_sort_order ON services(sort_order);
CREATE INDEX idx_services_category_id_is_active ON services(category_id, is_active);

-- 17. Create Service Fields Table
CREATE TABLE IF NOT EXISTS service_fields (
  id BIGSERIAL PRIMARY KEY,
  service_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  label VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL,
  placeholder VARCHAR(255) NULL,
  description TEXT NULL,
  is_required BOOLEAN NOT NULL DEFAULT false,
  validation_rules JSON NULL,
  options JSON NULL,
  sort_order INTEGER NOT NULL DEFAULT 0,
  is_active BOOLEAN NOT NULL DEFAULT true,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  CONSTRAINT fk_service_fields_service_id FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
  CONSTRAINT uq_service_fields_service_id_name UNIQUE (service_id, name)
);
CREATE INDEX idx_service_fields_type ON service_fields(type);
CREATE INDEX idx_service_fields_is_required ON service_fields(is_required);
CREATE INDEX idx_service_fields_sort_order ON service_fields(sort_order);
CREATE INDEX idx_service_fields_is_active ON service_fields(is_active);

-- 18. Create Service Requirements Table
CREATE TABLE IF NOT EXISTS service_requirements (
  id BIGSERIAL PRIMARY KEY,
  service_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT NULL,
  is_required BOOLEAN NOT NULL DEFAULT true,
  allowed_file_types JSON NULL,
  max_file_size INTEGER NULL,
  sort_order INTEGER NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  CONSTRAINT fk_service_requirements_service_id FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);
CREATE INDEX idx_service_requirements_is_required ON service_requirements(is_required);
CREATE INDEX idx_service_requirements_sort_order ON service_requirements(sort_order);

-- 19. Create Tickets Table
CREATE TABLE IF NOT EXISTS tickets (
  id BIGSERIAL PRIMARY KEY,
  uuid UUID NOT NULL UNIQUE,
  service_id BIGINT NOT NULL,
  user_id BIGINT NULL,
  organization_id BIGINT NULL,
  status VARCHAR(255) NOT NULL DEFAULT 'submitted',
  form_data JSON NULL,
  submitted_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  CONSTRAINT fk_tickets_service_id FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT,
  CONSTRAINT fk_tickets_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
CREATE INDEX idx_tickets_status ON tickets(status);
CREATE INDEX idx_tickets_organization_id ON tickets(organization_id);
CREATE INDEX idx_tickets_service_id_status ON tickets(service_id, status);
CREATE INDEX idx_tickets_user_id_status ON tickets(user_id, status);
CREATE INDEX idx_tickets_submitted_at ON tickets(submitted_at);

-- ============================================================
-- Migration Complete for PostgreSQL
-- ============================================================
