-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 18 apr 2024 kl 14:11
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `forskalleforumnet`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(17, 5, 9),
(18, 5, 10),
(20, 5, 14);

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`id`, `email`, `comment`, `thread_id`, `time`, `username`) VALUES
(4, 'holros@gmail.com', 'sebbe\r\n', 3, '2024-03-25 09:13:02', 'Hello'),
(5, 'holros@gmail.com', 'I love the oskis', 1, '2024-03-25 09:14:58', 'Hello'),
(6, 'sebbe@bugslider.com', 'Who is this guy \"hello\"??', 1, '2024-03-25 09:22:34', 'SebbeCool123'),
(7, 'sbe', 'hello\r\n', 4, '2024-04-10 15:58:27', 'asd'),
(8, 'kasper@kaspis.kasper', 'what is up with da oskis?\r\n', 1, '2024-04-15 07:59:30', 'asdf'),
(9, 'oskis@skolis.fj', 'He is small and look like no good ;(', 5, '2024-04-15 08:24:11', 'Oskis'),
(10, 'kasper@kaspis.kasper', 'fuck ur ballsack lookin ass\r\n', 5, '2024-04-15 08:24:12', 'asdf'),
(11, 'oskis@skolis.fj', 'helklo\'', 5, '2024-04-15 08:27:58', 'Oskis'),
(12, 'oskis@skolis.fj', '\' OR PASSWORD=1--', 5, '2024-04-15 08:30:17', 'Oskis'),
(13, 'oskis@skolis.fj', '\' OR PASSWORD=1--', 5, '2024-04-15 08:30:55', 'Oskis'),
(14, 'oskis@skolis.fj', 'hello\'', 5, '2024-04-15 08:31:03', 'Oskis'),
(15, 'kasper@kaspis.kasper', 'what? Where is everyone?', 4, '2024-04-18 11:09:31', 'Hello');

-- --------------------------------------------------------

--
-- Tabellstruktur `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `threads`
--

INSERT INTO `threads` (`id`, `title`) VALUES
(1, 'Whats up with the oskis'),
(3, 'Oskis is nr.1'),
(4, 'Celebrate good times cmon'),
(5, 'Why does my cat look like my ball sac?');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(32) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `name` varchar(24) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `userName`, `passwd`, `name`, `email`, `profile_picture`) VALUES
(5, 'Oskis', '$2y$10$wW29cgV8ckMtHyp26xqiCOM8Kymy8naA5glhEIgT26NXgdPd.l.GW', '', 'oskis@skolis.fj', 'profilePictures/Mouse referens.png'),
(8, 'Hello', '$2y$10$dKOdUO3T7gGVCGY5etc8w.5105mBYI6nPN4Pfy.rYOMf/iQqusMQ6', '', 'kasper@kaspis.kasper', NULL);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index för tabell `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Index för tabell `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT för tabell `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT för tabell `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Restriktioner för tabell `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
