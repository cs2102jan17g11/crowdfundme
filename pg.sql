/*
--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.1
-- Dumped by pg_dump version 9.6.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: projects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE projects (
    name character varying(255) NOT NULL,
    contents text,
    owner character varying(255) NOT NULL
);


ALTER TABLE projects OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE users (
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    fullname character varying(255) NOT NULL
);


ALTER TABLE users OWNER TO postgres;

--
-- Data for Name: projects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY projects (name, contents, owner) FROM stdin;
DBMS	A database is an organized collection of data.[1] It is the collection of schemas, tables, queries, reports, views, and other objects. The data are typically organized to model aspects of reality in a way that supports processes requiring information, such as modelling the availability of rooms in hotels in a way that supports finding a hotel with vacancies.	kenlsm
Teribble	Mister Terrible is a fictional character, a supervillain published by DC Comics. He first appears in Villains United #5 (December 2005), and was created by Gail Simone and Dale Eaglesham.	ryan
Faceless	Faceless is the third studio album by the band Godsmack. The album introduced drummer Shannon Larkin, former drummer for Ugly Kid Joe.[1] The album was released on April 8, 2003.\n\nThe songs "Straight Out of Line" and "I Stand Alone" had Grammy nominations for 'Best Rock Song' and, 'Best Hard Rock Performance' respectively.[2]	longyuan
Apples	The apple tree (Malus pumila, commonly and erroneously called Malus domestica) is a deciduous tree in the rose family best known for its sweet, pomaceous fruit, the apple. It is cultivated worldwide as a fruit tree, and is the most widely grown species in the genus Malus. The tree originated in Central Asia, where its wild ancestor, Malus sieversii, is still found today. Apples have been grown for thousands of years in Asia and Europe, and were brought to North America by European colonists. Apples have religious and mythological significance in many cultures, including Norse, Greek and European Christian traditions.	changhui
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (username, password, fullname) FROM stdin;
kenlsm	password	Ken Lee Shu Ming
ryan	password	Ryan
longyuan	password	Long Yuan
changhui	password	Chang Hui
vatsala	password	Vatsala Verma
\.


--
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (name, owner);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (username);


--
-- Name: projects projects_owner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_owner_fkey FOREIGN KEY (owner) REFERENCES users(username) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

*/