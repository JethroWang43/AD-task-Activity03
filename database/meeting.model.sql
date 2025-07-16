-- Active: 1752557012198@@127.0.0.1@5555@calendardb
CREATE TABLE IF NOT EXISTS meeting (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
