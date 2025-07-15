-- Active: 1752557012198@@127.0.0.1@5555@calendardb
CREATE TABLE IF NOT EXISTS tasks (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    meeting_id uuid REFERENCES meeting(id),
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    assigned_to uuid REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);