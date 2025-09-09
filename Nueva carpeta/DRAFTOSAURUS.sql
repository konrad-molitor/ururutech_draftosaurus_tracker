-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 09 2025 г., 19:06
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `DRAFTOSAURUS`
--

-- --------------------------------------------------------

--
-- Структура таблицы `USERS`
--

CREATE TABLE `USERS` (
  `id` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','player') NOT NULL DEFAULT 'player'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `USERS`
--

INSERT INTO `USERS` (`id`, `name`, `birthday`, `email`, `password`, `role`) VALUES
(1, 'Admin', '1984-07-20', 'admin@ururutech.com', '$2y$10$HsiMf5DmWSVCuUn5RtZNWe2ZOWqF6bH.aPhfNgywn5DX.2xN2tmVW', 'admin'),
(2, 'Jane', '1984-07-20', 'test@test.com', '$2y$10$Z4kfSBlt4Dmn1Lav9FxA6ueEnxQX4chBS3WsUXiRoZbZKm994Cdr2', 'player'),
(3, 'Aaron', '2006-10-28', 'email1@email.com', '$2y$10$6.cokGDHpHKLPZK83pvqxO9nsNXjaV2OUnX6zzJALqvn9luhLc8J.', 'player'),
(4, 'Ali', '2007-03-20', 'ali@gmail.com', '$2y$10$9P5JNC78PmbQHiqKoynmh.jm/crO9yc4txDhowDOah1hT/Job4E52', 'player'),
(5, 'Thiago', '2008-03-20', 'thiago@gmail.com', '$2y$10$.4.wDWQQvvEW3osxobfbAe7lDogVLG8Ju6dXrhujWKbJ50JCtxrta', 'player'),
(6, 'Valentino', '2005-08-10', 'valentino@mail.com', '$2y$10$Pw0WajkSgEbpWWFvihXlYuaCoX3xpf6DGLFb/deE1NBfDx/3SZrmi', 'player'),
(7, 'Oleg', '2005-09-26', 'oleg@gmail.com', '$2y$10$i4xjGr0ifmPfHkVYTh4cp.N0hhipFXteAqcAu.0FxKAgpx4MQqB/i', 'player'),
(8, 'Konrad', '1991-03-12', 'konrad@email.com', '$2y$10$7Jjiv/ZKuBCfjvbDHJGSAe6xEk8AXG1sM0azzh7tNa8qSBNYP30gm', 'player'),
(13, 'тестовый', '1111-01-01', 'delete@mail.com', '$2y$10$lrM7Vev1IzyoRZQYmEqZFeOh6t2PIxsYMXsosYQ37XCUkEIlLywjG', 'player'),
(14, 'delete', '1111-01-01', 'delete2@gmail.com', '$2y$10$2zHkzOkC8P9KxTcLuWcs1uhQefsIjmTIvNytq8MmLq4SVVGxihXT2', 'player');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
