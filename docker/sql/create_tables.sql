DROP TABLE IF EXISTS `songs`;
DROP TABLE IF EXISTS `artists`;

CREATE TABLE `artists` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `genre` VARCHAR(100) DEFAULT NULL,
    `country` VARCHAR(100) DEFAULT NULL,
    `bio` TEXT DEFAULT NULL,
    `imageUrl` VARCHAR(500) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `artists` (`id`, `name`, `genre`, `country`, `bio`, `imageUrl`) VALUES
(
    1,
    'Nirvana',
    'Grunge / Alternative Rock',
    'United States',
    'American rock band formed in Aberdeen, Washington in 1987 by Kurt Cobain and Krist Novoselic. Known for raw dynamic shifts and accessible open-chord acoustic arrangements.',
    NULL
),
(
    2,
    'Oasis',
    'Britpop / Rock',
    'United Kingdom',
    'English rock band formed in Manchester in 1991. Famous for anthemic acoustic guitar progressions built around suspended shapes like Em7, Dsus4, A7sus4, and Cadd9.',
    NULL
),
(
    3,
    'Bob Dylan',
    'Folk Rock',
    'United States',
    'American singer-songwriter whose folk and folk-rock catalog relies on timeless three- and four-chord open progressions ideal for rhythm guitarists.',
    NULL
),
(
    4,
    'The Cranberries',
    'Alternative Rock',
    'Ireland',
    'Irish alternative rock band formed in Limerick in 1989. Their signature sound blends jangly open chords with expressive strumming dynamics.',
    NULL
),
(
    5,
    'Tom Petty',
    'Heartland Rock',
    'United States',
    'American musician and songwriter known for crisp, driving acoustic rhythm guitar parts built around classic open D, G, and A chord voicings.',
    NULL
),
(
    6,
    'R.E.M.',
    'Alternative Rock',
    'United States',
    'American alternative rock band formed in Athens, Georgia in 1980, celebrated for arpeggiated minor-chord riffs and melodic acoustic strumming.',
    NULL
);

CREATE TABLE `songs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `artistId` INT UNSIGNED DEFAULT NULL,
    `title` VARCHAR(255) NOT NULL,
    `difficulty` VARCHAR(50) NOT NULL DEFAULT 'Beginner',
    `chords` VARCHAR(255) NOT NULL,
    `tags` VARCHAR(255) DEFAULT NULL,
    `lyrics` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_songs_artistId` (`artistId`),
    CONSTRAINT `fk_songs_artist`
        FOREIGN KEY (`artistId`) REFERENCES `artists` (`id`)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `songs` (`artistId`, `title`, `difficulty`, `chords`, `tags`, `lyrics`) VALUES
(
    1,
    'Come As You Are',
    'Beginner',
    'Em · D · Am · C',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm  D  Em  D\n\n[Verse 1]\nEm              D               Em\nCome as you are, as you were\n        D                Em\nAs I want you to be\n        D               Em\nAs a friend, as a friend\n        D               Em\nAs an old enemy\n\n[Chorus]\nAm              C\nMemoria, memoria\nAm              C\nMemoria, memoria"
),
(
    2,
    'Wonderwall',
    'Intermediate',
    'Em7 · G · Dsus4 · A7sus4 · Cadd9',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm7  G  Dsus4  A7sus4 (x4)\n\n[Verse 1]\nEm7            G\nToday is gonna be the day\n          Dsus4                  A7sus4\nThat they're gonna throw it back to you\nEm7             G\nBy now you should've somehow\n    Dsus4                A7sus4\nRealized what you gotta do\n\n[Chorus]\nCadd9        Em7          G       Em7\nAnd all the roads we have to walk are winding\nCadd9        Em7          G        Em7\nAnd all the lights that lead us there are blinding"
),
(
    3,
    'Knockin'' on Heaven''s Door',
    'Beginner',
    'G · D · Am · C',
    'No barre, Folk rock, Open chords',
    "[Intro]\nG  D  Am7\nG  D  C\n\n[Verse 1]\nG              D                 Am7\nMama, take this badge off of me\nG           D              C\nI can't use it anymore\nG              D                 Am7\nIt's gettin' dark, too dark to see\nG                D                   C\nI feel I'm knockin' on heaven's door\n\n[Chorus]\nG            D                   Am7\nKnock, knock, knockin' on heaven's door\nG            D                   C\nKnock, knock, knockin' on heaven's door"
),
(
    4,
    'Zombie',
    'Beginner',
    'Em · C · G · D',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm  C  G  D (x4)\n\n[Verse 1]\nEm                      C\nAnother head hangs lowly\nG                        D\nChild is slowly taken\nEm                         C\nAnd the violence caused such silence\nG                    D\nWho are we mistaken?\n\n[Chorus]\n             Em                C\nIn your head, in your head, they are fighting\n             G                 D\nWith their tanks, and their bombs\nAnd their bombs, and their guns\nIn your head, in your head, they are crying"
),
(
    5,
    'Free Fallin''',
    'Beginner',
    'D · G · A',
    'No barre, Rock, Open chords',
    "[Intro]\nD  G  G  D  A (x2)\n\n[Verse 1]\nD                G       G          D    A\nShe's a good girl, loves her mama\nD                G       G          D    A\nLoves Jesus and America too\nD                G         G          D     A\nShe's a good girl, crazy 'bout Elvis\nD                G           G          D    A\nLoves horses and her boyfriend too\n\n[Chorus]\n          D     G          G     D     A\nAnd I'm free, free fallin'\n       D     G          G     D     A\nYeah I'm free, free fallin'"
),
(
    6,
    'Losing My Religion',
    'Intermediate',
    'Am · Em · Dm · G · C',
    'No barre, 90s rock, Open chords',
    "[Intro]\nG  Am  Em  Am  Em  Dm  G\n\n[Verse 1]\n         Am               Em\nOh, life is bigger\n          Am\nIt's bigger than you\n            Em\nAnd you are not me\nThe lengths that I will go to\n                  Am\nThe distance in your eyes\n         Em              Dm        G\nOh no, I've said too much, I set it up\n\n[Chorus]\n            Am\nThat's me in the corner\n            Em\nThat's me in the spotlight\n            Am\nLosing my religion"
),
(
    1,
    'About a Girl',
    'Beginner',
    'Em · G · C#m · G# · A · E',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm  G  Em  G (x2)\n\n[Verse 1]\nEm                G\nI need an easy friend\nEm                        G\nI do, with an ear to lend\nEm                   G\nI do think you fit this shoe\nEm                        G\nI do, won't you have a clue?"
),
(
    2,
    'Songbird',
    'Beginner',
    'G · Dsus4 · Em7',
    'No barre, Rock, Open chords',
    "[Intro]\nG  Dsus4  Em7 (x2)\n\n[Verse 1]\nG                                  Dsus4          Em7\nTalking to the songbird yesterday\nG                                      Dsus4      Em7\nFlew me to a place not far away\nG                                    Dsus4        Em7\nShe's a little pilot in my mind\nG                                        Dsus4    Em7\nSinging songs of love to pass the time"
);
