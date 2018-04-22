CREATE DATABASE minesweeper_service;
USE minesweeper_service;
CREATE TABLE User (
	ID int,
	name varchar(20),
	password varchar(255),
	PRIMARY KEY (ID)
);
CREATE TABLE EasyDifficulty (
	uID int,
	highscore int,
	date_achieved datetime,
	time_taken int
);
CREATE TABLE MediumDifficulty (
	uID int,
	highscore int,
	date_achieved datetime,
	time_taken int
);
CREATE TABLE HardDifficulty (
	uID int,
	highscore int,
	date_achieved datetime,
	time_taken int
);