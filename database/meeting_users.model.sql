-- Active: 1752557012198@@127.0.0.1@5555
CREATE TABLE IF NOT EXISTS meeting_users (
    meeting_id uuid NOT NULL REFERENCES meeting(id),
    user_id uuid NOT NULL REFERENCES users(id),
    PRIMARY KEY (meeting_id, user_id)
);
