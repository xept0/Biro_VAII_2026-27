DROP TABLE IF EXISTS `songs`;

CREATE TABLE `songs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `artist` VARCHAR(255) NOT NULL,
    `difficulty` VARCHAR(50) NOT NULL DEFAULT 'Beginner',
    `chords` VARCHAR(255) NOT NULL,
    `tags` VARCHAR(255) DEFAULT NULL,
    `lyrics` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `songs` (`title`, `artist`, `difficulty`, `chords`, `tags`, `lyrics`) VALUES
(
    'Come As You Are',
    'Nirvana',
    'Beginner',
    'Em · D · Am · C',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm  D  Em  D\n\n[Verse 1]\nEm              D               Em\nCome as you are, as you were\n        D                Em\nAs I want you to be\n        D               Em\nAs a friend, as a friend\n        D               Em\nAs an old enemy\n\n[Chorus]\nAm              C\nMemoria, memoria\nAm              C\nMemoria, memoria"
),
(
    'Wonderwall',
    'Oasis',
    'Intermediate',
    'Em7 · G · Dsus4 · A7sus4 · Cadd9',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm7  G  Dsus4  A7sus4 (x4)\n\n[Verse 1]\nEm7            G\nToday is gonna be the day\n          Dsus4                  A7sus4\nThat they're gonna throw it back to you\nEm7             G\nBy now you should've somehow\n    Dsus4                A7sus4\nRealized what you gotta do\n\n[Chorus]\nCadd9        Em7          G       Em7\nAnd all the roads we have to walk are winding\nCadd9        Em7          G        Em7\nAnd all the lights that lead us there are blinding"
),
(
    'Knockin'' on Heaven''s Door',
    'Bob Dylan',
    'Beginner',
    'G · D · Am · C',
    'No barre, Folk rock, Open chords',
    "[Intro]\nG  D  Am7\nG  D  C\n\n[Verse 1]\nG              D                 Am7\nMama, take this badge off of me\nG           D              C\nI can't use it anymore\nG              D                 Am7\nIt's gettin' dark, too dark to see\nG                D                   C\nI feel I'm knockin' on heaven's door\n\n[Chorus]\nG            D                   Am7\nKnock, knock, knockin' on heaven's door\nG            D                   C\nKnock, knock, knockin' on heaven's door"
),
(
    'Zombie',
    'The Cranberries',
    'Beginner',
    'Em · C · G · D',
    'No barre, 90s rock, Open chords',
    "[Intro]\nEm  C  G  D (x4)\n\n[Verse 1]\nEm                      C\nAnother head hangs lowly\nG                        D\nChild is slowly taken\nEm                         C\nAnd the violence caused such silence\nG                    D\nWho are we mistaken?\n\n[Chorus]\n             Em                C\nIn your head, in your head, they are fighting\n             G                 D\nWith their tanks, and their bombs\nAnd their bombs, and their guns\nIn your head, in your head, they are crying"
),
(
    'Free Fallin''',
    'Tom Petty',
    'Beginner',
    'D · G · A',
    'No barre, Rock, Open chords',
    "[Intro]\nD  G  G  D  A (x2)\n\n[Verse 1]\nD                G       G          D    A\nShe's a good girl, loves her mama\nD                G       G          D    A\nLoves Jesus and America too\nD                G         G          D     A\nShe's a good girl, crazy 'bout Elvis\nD                G           G          D    A\nLoves horses and her boyfriend too\n\n[Chorus]\n          D     G          G     D     A\nAnd I'm free, free fallin'\n       D     G          G     D     A\nYeah I'm free, free fallin'"
),
(
    'Losing My Religion',
    'R.E.M.',
    'Intermediate',
    'Am · Em · Dm · G · C',
    'No barre, 90s rock, Open chords',
    "[Intro]\nG  Am  Em  Am  Em  Dm  G\n\n[Verse 1]\n         Am               Em\nOh, life is bigger\n          Am\nIt's bigger than you\n            Em\nAnd you are not me\nThe lengths that I will go to\n                  Am\nThe distance in your eyes\n         Em              Dm        G\nOh no, I've said too much, I set it up\n\n[Chorus]\n            Am\nThat's me in the corner\n            Em\nThat's me in the spotlight\n            Am\nLosing my religion"
);
