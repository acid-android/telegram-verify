-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 04 2018 г., 14:06
-- Версия сервера: 10.1.35-MariaDB
-- Версия PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `telegram_verify`
--

-- --------------------------------------------------------

--
-- Структура таблицы `google_tfa`
--

CREATE TABLE `google_tfa` (
  `id` int(10) UNSIGNED NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `telegram_chats`
--

CREATE TABLE `telegram_chats` (
  `id` int(10) UNSIGNED NOT NULL,
  `chat_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `telegram_tfa`
--

CREATE TABLE `telegram_tfa` (
  `id` int(10) UNSIGNED NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `telegram` text NOT NULL,
  `password` text NOT NULL,
  `hash` text NOT NULL,
  `tfv_state` int(1) DEFAULT NULL,
  `tfa_type` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `google_tfa`
--
ALTER TABLE `google_tfa`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `telegram_chats`
--
ALTER TABLE `telegram_chats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `telegram_tfa`
--
ALTER TABLE `telegram_tfa`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `google_tfa`
--
ALTER TABLE `google_tfa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `telegram_chats`
--
ALTER TABLE `telegram_chats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `telegram_tfa`
--
ALTER TABLE `telegram_tfa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
