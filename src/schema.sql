-- Please write your schema here:

CREATE TABLE events
(
    event_id INT NOT NULL AUTO_INCREMENT,
    remoteId VARCHAR(255),
    title VARCHAR(255),
    date VARCHAR(255),
    time VARCHAR(255),
    image VARCHAR(255),
    description VARCHAR(255),
    venueName VARCHAR(255),
    PRIMARY KEY(event_id)
);

CREATE TABLE tickets
(
    ticket_id INT NOT NULL AUTO_INCREMENT,
    price VARCHAR(255),
    link VARCHAR(255),
    seller VARCHAR(255),
    PRIMARY KEY(ticket_id)
);

CREATE TABLE events_tickets
(
    event_tickets_id INT NOT NULL AUTO_INCREMENT,
    event_id INT,
    ticket_id INT,
    PRIMARY KEY(event_tickets_id),

    FOREIGN KEY (event_id)
      REFERENCES event(event_id),

    FOREIGN KEY (ticket_id)
      REFERENCES ticket(ticket_id)
      ON DELETE CASCADE
);
