-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 20, 2023 at 05:45 PM
-- Server version: 5.7.43
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devaigiapp_elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `userId` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` smallint(6) DEFAULT '1' COMMENT '1(Active), 0(Deactive)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`userId`, `name`, `username`, `email`, `password`, `created`, `edited`, `status`) VALUES
(1, 'Super Admin', 'admin', 'info@elearning.com', '$2y$10$9nY7dWxENHr13rk3Uzmkn.uYKAn5Qm725icoNrIYIvvTY.Mx67Bfi', '2022-05-27 07:31:31', '2022-06-02 12:05:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `badgeId` bigint(20) NOT NULL,
  `badgeName` varchar(255) DEFAULT NULL,
  `badgeImage` varchar(255) DEFAULT NULL,
  `descriptions` text,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1-Active,0-Inactive',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`badgeId`, `badgeName`, `badgeImage`, `descriptions`, `status`, `created`, `updated`) VALUES
(1, 'First', 'bag_1.png', '90 to 100 %', 1, '2021-07-15 14:32:45', '2021-07-15 09:27:35'),
(2, 'Second', 'bag_2.png', '80 to 90%', 1, '2021-07-15 14:32:45', '2021-07-15 09:27:44'),
(3, 'Third', 'bag_3.png', '70 to 80%', 1, '2021-07-15 14:32:45', '2021-07-15 09:28:11'),
(4, 'Fourth', 'bag_4.png', '60 to 70%', 1, '2021-07-15 14:32:45', '2021-07-15 09:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `articleId` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `descriptions` text,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0=Inactive, 1=Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`articleId`, `title`, `thumbnail`, `descriptions`, `created`, `updated`, `status`) VALUES
(1, 'Test Blog 6', 'blog_811664169224.jpg', '&lt;p&gt;As our elementary students head back to school in person, in this very new way, there will be many emotions stirred up in them. Alarm. Frustration. Worry. Excitement. &lt;/p&gt;\n                            &lt;p&gt;And this will be mirrored by what we, as adults, may also be experiencing. For our teachers, on top of what they will be emotionally experiencing themselves, they are being called to be the caring leaders that guide our students to a place where they can learn together.&lt;/p&gt;\n                            &lt;blockquote class=&quot;blockquote&quot;&gt;\n                                &lt;p&gt;This is going to be a challenging dance. Our teachers are true change makers. They are providers and they are leaders and this period in history is going to shine a light on their vital role in our children’s emotional health.&lt;/p&gt;\n                            &lt;/blockquote&gt;\n                            &lt;p&gt;So, how can we support them to support our children’s learning? As parents and school administrators, we can relax about the ‘learning’ and trust it will come. Schools are going to need to change the focus right now to concentrating on the emotional basics before academic basics. Teachers teach people, not subjects. And when they can focus on supporting well-being first, the learning may then have an opportunity to land. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Let’s take a closer look at the 3 R’s of emotional basics:&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Relationship&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;What our students need from us is..us. They need to know we are there for them, and that they matter. It’s not so much about what we say—it’s about how we make them feel in our presence: invited, accepted, and seen. &lt;/p&gt;\n                            &lt;p&gt;During this emotionally turbulent time, we will need to make conscious invitations into relationship so that our students can feel connected to us. This might mean special greeting rituals at the beginning of each day and more playful activities in which we join in. These attachment practices can help our students to feel connected to us, which may also lower their anxiety. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Rhythm&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Children crave rhythm.&lt;/p&gt;\n                            &lt;p&gt;Consistent routines, rituals, and structures help children feel safe. They can lean on these and rely on them. Yet most children are experiencing the exact opposite right now. And as they look to returning to school, they may have little to no sense of what the ‘new normal’ will be. We can create a sense of safety by quickly establishing new routines that our students can count on and orient around. This will help to produce a rhythm to their days and can offer a sense of predictability in these unpredictable times.&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Release&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Our students’ emotions will be stirred up. And we know that when emotions get stirred up, they need somewhere to go. Finding healthy ways to pre-emptively channel this emotional energy for our students can help to alleviate dangerous or disruptive eruptions. Integrating daily outlets for release can be especially helpful for supporting students to get out frustration before it leads to outbursts of aggression.&lt;/p&gt;\n                            &lt;p&gt;These outlets can also help students to reflect on and express their feelings in ways that don’t make them feel self-conscious. The beauty of this practice is that we don’t even have to know what is specifically going on for a child. We are simply facilitating a way for the emotion to be expressed and released indirectly in a natural way—whether through music, physical movement, stories or storytelling, writing, poetry, drama, art, or even simply being outdoors. All of these outlets are powerful because they help us come closer to our feelings and to experiencing a sense of release and emotional rest.&lt;/p&gt;\n                            &lt;p&gt;Going back to school during this time will not be easy. We will need to be creative and think outside the box. We may need to stretch muscles we never knew we had. But it may be helpful to remember that this is not a time to focus on outcome and performance, or getting ahead or even catching up. Shifting our attention to matters of the heart will help our students feel safe. This is what will set the stage for learning to happen – when children are ready.&lt;/p&gt;\n                            &lt;p&gt;In the meantime, let’s be patient with our students and ourselves. We are all in this together.&lt;/p&gt;', '2022-05-12 13:20:26', '2022-09-26 06:08:27', 1),
(2, 'Test Blog 5', 'blog_341664169202.jpg', '&lt;p&gt;As our elementary students head back to school in person, in this very new way, there will be many emotions stirred up in them. Alarm. Frustration. Worry. Excitement. &lt;/p&gt;\n                            &lt;p&gt;And this will be mirrored by what we, as adults, may also be experiencing. For our teachers, on top of what they will be emotionally experiencing themselves, they are being called to be the caring leaders that guide our students to a place where they can learn together.&lt;/p&gt;\n                            &lt;blockquote class=&quot;blockquote&quot;&gt;\n                                &lt;p&gt;This is going to be a challenging dance. Our teachers are true change makers. They are providers and they are leaders and this period in history is going to shine a light on their vital role in our children’s emotional health.&lt;/p&gt;\n                            &lt;/blockquote&gt;\n                            &lt;p&gt;So, how can we support them to support our children’s learning? As parents and school administrators, we can relax about the ‘learning’ and trust it will come. Schools are going to need to change the focus right now to concentrating on the emotional basics before academic basics. Teachers teach people, not subjects. And when they can focus on supporting well-being first, the learning may then have an opportunity to land. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Let’s take a closer look at the 3 R’s of emotional basics:&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Relationship&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;What our students need from us is..us. They need to know we are there for them, and that they matter. It’s not so much about what we say—it’s about how we make them feel in our presence: invited, accepted, and seen. &lt;/p&gt;\n                            &lt;p&gt;During this emotionally turbulent time, we will need to make conscious invitations into relationship so that our students can feel connected to us. This might mean special greeting rituals at the beginning of each day and more playful activities in which we join in. These attachment practices can help our students to feel connected to us, which may also lower their anxiety. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Rhythm&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Children crave rhythm.&lt;/p&gt;\n                            &lt;p&gt;Consistent routines, rituals, and structures help children feel safe. They can lean on these and rely on them. Yet most children are experiencing the exact opposite right now. And as they look to returning to school, they may have little to no sense of what the ‘new normal’ will be. We can create a sense of safety by quickly establishing new routines that our students can count on and orient around. This will help to produce a rhythm to their days and can offer a sense of predictability in these unpredictable times.&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Release&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Our students’ emotions will be stirred up. And we know that when emotions get stirred up, they need somewhere to go. Finding healthy ways to pre-emptively channel this emotional energy for our students can help to alleviate dangerous or disruptive eruptions. Integrating daily outlets for release can be especially helpful for supporting students to get out frustration before it leads to outbursts of aggression.&lt;/p&gt;\n                            &lt;p&gt;These outlets can also help students to reflect on and express their feelings in ways that don’t make them feel self-conscious. The beauty of this practice is that we don’t even have to know what is specifically going on for a child. We are simply facilitating a way for the emotion to be expressed and released indirectly in a natural way—whether through music, physical movement, stories or storytelling, writing, poetry, drama, art, or even simply being outdoors. All of these outlets are powerful because they help us come closer to our feelings and to experiencing a sense of release and emotional rest.&lt;/p&gt;\n                            &lt;p&gt;Going back to school during this time will not be easy. We will need to be creative and think outside the box. We may need to stretch muscles we never knew we had. But it may be helpful to remember that this is not a time to focus on outcome and performance, or getting ahead or even catching up. Shifting our attention to matters of the heart will help our students feel safe. This is what will set the stage for learning to happen – when children are ready.&lt;/p&gt;\n                            &lt;p&gt;In the meantime, let’s be patient with our students and ourselves. We are all in this together.&lt;/p&gt;', '2022-05-12 13:22:45', '2022-09-26 06:08:32', 1),
(4, 'Test Blog 4', 'blog_341664169186.jpg', '&lt;p&gt;As our elementary students head back to school in person, in this very new way, there will be many emotions stirred up in them. Alarm. Frustration. Worry. Excitement. &lt;/p&gt;\n                            &lt;p&gt;And this will be mirrored by what we, as adults, may also be experiencing. For our teachers, on top of what they will be emotionally experiencing themselves, they are being called to be the caring leaders that guide our students to a place where they can learn together.&lt;/p&gt;\n                            &lt;blockquote class=&quot;blockquote&quot;&gt;\n                                &lt;p&gt;This is going to be a challenging dance. Our teachers are true change makers. They are providers and they are leaders and this period in history is going to shine a light on their vital role in our children’s emotional health.&lt;/p&gt;\n                            &lt;/blockquote&gt;\n                            &lt;p&gt;So, how can we support them to support our children’s learning? As parents and school administrators, we can relax about the ‘learning’ and trust it will come. Schools are going to need to change the focus right now to concentrating on the emotional basics before academic basics. Teachers teach people, not subjects. And when they can focus on supporting well-being first, the learning may then have an opportunity to land. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Let’s take a closer look at the 3 R’s of emotional basics:&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Relationship&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;What our students need from us is..us. They need to know we are there for them, and that they matter. It’s not so much about what we say—it’s about how we make them feel in our presence: invited, accepted, and seen. &lt;/p&gt;\n                            &lt;p&gt;During this emotionally turbulent time, we will need to make conscious invitations into relationship so that our students can feel connected to us. This might mean special greeting rituals at the beginning of each day and more playful activities in which we join in. These attachment practices can help our students to feel connected to us, which may also lower their anxiety. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Rhythm&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Children crave rhythm.&lt;/p&gt;\n                            &lt;p&gt;Consistent routines, rituals, and structures help children feel safe. They can lean on these and rely on them. Yet most children are experiencing the exact opposite right now. And as they look to returning to school, they may have little to no sense of what the ‘new normal’ will be. We can create a sense of safety by quickly establishing new routines that our students can count on and orient around. This will help to produce a rhythm to their days and can offer a sense of predictability in these unpredictable times.&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Release&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Our students’ emotions will be stirred up. And we know that when emotions get stirred up, they need somewhere to go. Finding healthy ways to pre-emptively channel this emotional energy for our students can help to alleviate dangerous or disruptive eruptions. Integrating daily outlets for release can be especially helpful for supporting students to get out frustration before it leads to outbursts of aggression.&lt;/p&gt;\n                            &lt;p&gt;These outlets can also help students to reflect on and express their feelings in ways that don’t make them feel self-conscious. The beauty of this practice is that we don’t even have to know what is specifically going on for a child. We are simply facilitating a way for the emotion to be expressed and released indirectly in a natural way—whether through music, physical movement, stories or storytelling, writing, poetry, drama, art, or even simply being outdoors. All of these outlets are powerful because they help us come closer to our feelings and to experiencing a sense of release and emotional rest.&lt;/p&gt;\n                            &lt;p&gt;Going back to school during this time will not be easy. We will need to be creative and think outside the box. We may need to stretch muscles we never knew we had. But it may be helpful to remember that this is not a time to focus on outcome and performance, or getting ahead or even catching up. Shifting our attention to matters of the heart will help our students feel safe. This is what will set the stage for learning to happen – when children are ready.&lt;/p&gt;\n                            &lt;p&gt;In the meantime, let’s be patient with our students and ourselves. We are all in this together.&lt;/p&gt;', '2022-05-12 13:22:45', '2022-09-26 06:08:38', 1),
(5, 'Test Blog 3', 'blog_141664169173.jpg', '&lt;p&gt;As our elementary students head back to school in person, in this very new way, there will be many emotions stirred up in them. Alarm. Frustration. Worry. Excitement. &lt;/p&gt;\n                            &lt;p&gt;And this will be mirrored by what we, as adults, may also be experiencing. For our teachers, on top of what they will be emotionally experiencing themselves, they are being called to be the caring leaders that guide our students to a place where they can learn together.&lt;/p&gt;\n                            &lt;blockquote class=&quot;blockquote&quot;&gt;\n                                &lt;p&gt;This is going to be a challenging dance. Our teachers are true change makers. They are providers and they are leaders and this period in history is going to shine a light on their vital role in our children’s emotional health.&lt;/p&gt;\n                            &lt;/blockquote&gt;\n                            &lt;p&gt;So, how can we support them to support our children’s learning? As parents and school administrators, we can relax about the ‘learning’ and trust it will come. Schools are going to need to change the focus right now to concentrating on the emotional basics before academic basics. Teachers teach people, not subjects. And when they can focus on supporting well-being first, the learning may then have an opportunity to land. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Let’s take a closer look at the 3 R’s of emotional basics:&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Relationship&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;What our students need from us is..us. They need to know we are there for them, and that they matter. It’s not so much about what we say—it’s about how we make them feel in our presence: invited, accepted, and seen. &lt;/p&gt;\n                            &lt;p&gt;During this emotionally turbulent time, we will need to make conscious invitations into relationship so that our students can feel connected to us. This might mean special greeting rituals at the beginning of each day and more playful activities in which we join in. These attachment practices can help our students to feel connected to us, which may also lower their anxiety. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Rhythm&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Children crave rhythm.&lt;/p&gt;\n                            &lt;p&gt;Consistent routines, rituals, and structures help children feel safe. They can lean on these and rely on them. Yet most children are experiencing the exact opposite right now. And as they look to returning to school, they may have little to no sense of what the ‘new normal’ will be. We can create a sense of safety by quickly establishing new routines that our students can count on and orient around. This will help to produce a rhythm to their days and can offer a sense of predictability in these unpredictable times.&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Release&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Our students’ emotions will be stirred up. And we know that when emotions get stirred up, they need somewhere to go. Finding healthy ways to pre-emptively channel this emotional energy for our students can help to alleviate dangerous or disruptive eruptions. Integrating daily outlets for release can be especially helpful for supporting students to get out frustration before it leads to outbursts of aggression.&lt;/p&gt;\n                            &lt;p&gt;These outlets can also help students to reflect on and express their feelings in ways that don’t make them feel self-conscious. The beauty of this practice is that we don’t even have to know what is specifically going on for a child. We are simply facilitating a way for the emotion to be expressed and released indirectly in a natural way—whether through music, physical movement, stories or storytelling, writing, poetry, drama, art, or even simply being outdoors. All of these outlets are powerful because they help us come closer to our feelings and to experiencing a sense of release and emotional rest.&lt;/p&gt;\n                            &lt;p&gt;Going back to school during this time will not be easy. We will need to be creative and think outside the box. We may need to stretch muscles we never knew we had. But it may be helpful to remember that this is not a time to focus on outcome and performance, or getting ahead or even catching up. Shifting our attention to matters of the heart will help our students feel safe. This is what will set the stage for learning to happen – when children are ready.&lt;/p&gt;\n                            &lt;p&gt;In the meantime, let’s be patient with our students and ourselves. We are all in this together.&lt;/p&gt;', '2022-07-21 07:56:51', '2022-09-26 06:08:43', 1),
(6, 'Test Blog 2', 'blog_681664169160.jpg', '&lt;p&gt;As our elementary students head back to school in person, in this very new way, there will be many emotions stirred up in them. Alarm. Frustration. Worry. Excitement. &lt;/p&gt;\n                            &lt;p&gt;And this will be mirrored by what we, as adults, may also be experiencing. For our teachers, on top of what they will be emotionally experiencing themselves, they are being called to be the caring leaders that guide our students to a place where they can learn together.&lt;/p&gt;\n                            &lt;blockquote class=&quot;blockquote&quot;&gt;\n                                &lt;p&gt;This is going to be a challenging dance. Our teachers are true change makers. They are providers and they are leaders and this period in history is going to shine a light on their vital role in our children’s emotional health.&lt;/p&gt;\n                            &lt;/blockquote&gt;\n                            &lt;p&gt;So, how can we support them to support our children’s learning? As parents and school administrators, we can relax about the ‘learning’ and trust it will come. Schools are going to need to change the focus right now to concentrating on the emotional basics before academic basics. Teachers teach people, not subjects. And when they can focus on supporting well-being first, the learning may then have an opportunity to land. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Let’s take a closer look at the 3 R’s of emotional basics:&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Relationship&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;What our students need from us is..us. They need to know we are there for them, and that they matter. It’s not so much about what we say—it’s about how we make them feel in our presence: invited, accepted, and seen. &lt;/p&gt;\n                            &lt;p&gt;During this emotionally turbulent time, we will need to make conscious invitations into relationship so that our students can feel connected to us. This might mean special greeting rituals at the beginning of each day and more playful activities in which we join in. These attachment practices can help our students to feel connected to us, which may also lower their anxiety. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Rhythm&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Children crave rhythm.&lt;/p&gt;\n                            &lt;p&gt;Consistent routines, rituals, and structures help children feel safe. They can lean on these and rely on them. Yet most children are experiencing the exact opposite right now. And as they look to returning to school, they may have little to no sense of what the ‘new normal’ will be. We can create a sense of safety by quickly establishing new routines that our students can count on and orient around. This will help to produce a rhythm to their days and can offer a sense of predictability in these unpredictable times.&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Release&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Our students’ emotions will be stirred up. And we know that when emotions get stirred up, they need somewhere to go. Finding healthy ways to pre-emptively channel this emotional energy for our students can help to alleviate dangerous or disruptive eruptions. Integrating daily outlets for release can be especially helpful for supporting students to get out frustration before it leads to outbursts of aggression.&lt;/p&gt;\n                            &lt;p&gt;These outlets can also help students to reflect on and express their feelings in ways that don’t make them feel self-conscious. The beauty of this practice is that we don’t even have to know what is specifically going on for a child. We are simply facilitating a way for the emotion to be expressed and released indirectly in a natural way—whether through music, physical movement, stories or storytelling, writing, poetry, drama, art, or even simply being outdoors. All of these outlets are powerful because they help us come closer to our feelings and to experiencing a sense of release and emotional rest.&lt;/p&gt;\n                            &lt;p&gt;Going back to school during this time will not be easy. We will need to be creative and think outside the box. We may need to stretch muscles we never knew we had. But it may be helpful to remember that this is not a time to focus on outcome and performance, or getting ahead or even catching up. Shifting our attention to matters of the heart will help our students feel safe. This is what will set the stage for learning to happen – when children are ready.&lt;/p&gt;\n                            &lt;p&gt;In the meantime, let’s be patient with our students and ourselves. We are all in this together.&lt;/p&gt;', '2022-07-21 08:24:17', '2022-09-26 06:08:49', 1),
(7, 'Test Blog 1', 'blog_101664169748.jpg', '&lt;p&gt;As our elementary students head back to school in person, in this very new way, there will be many emotions stirred up in them. Alarm. Frustration. Worry. Excitement. &lt;/p&gt;\n                            &lt;p&gt;And this will be mirrored by what we, as adults, may also be experiencing. For our teachers, on top of what they will be emotionally experiencing themselves, they are being called to be the caring leaders that guide our students to a place where they can learn together.&lt;/p&gt;\n                            &lt;blockquote class=&quot;blockquote&quot;&gt;\n                                &lt;p&gt;This is going to be a challenging dance. Our teachers are true change makers. They are providers and they are leaders and this period in history is going to shine a light on their vital role in our children’s emotional health.&lt;/p&gt;\n                            &lt;/blockquote&gt;\n                            &lt;p&gt;So, how can we support them to support our children’s learning? As parents and school administrators, we can relax about the ‘learning’ and trust it will come. Schools are going to need to change the focus right now to concentrating on the emotional basics before academic basics. Teachers teach people, not subjects. And when they can focus on supporting well-being first, the learning may then have an opportunity to land. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Let’s take a closer look at the 3 R’s of emotional basics:&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Relationship&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;What our students need from us is..us. They need to know we are there for them, and that they matter. It’s not so much about what we say—it’s about how we make them feel in our presence: invited, accepted, and seen. &lt;/p&gt;\n                            &lt;p&gt;During this emotionally turbulent time, we will need to make conscious invitations into relationship so that our students can feel connected to us. This might mean special greeting rituals at the beginning of each day and more playful activities in which we join in. These attachment practices can help our students to feel connected to us, which may also lower their anxiety. &lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Rhythm&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Children crave rhythm.&lt;/p&gt;\n                            &lt;p&gt;Consistent routines, rituals, and structures help children feel safe. They can lean on these and rely on them. Yet most children are experiencing the exact opposite right now. And as they look to returning to school, they may have little to no sense of what the ‘new normal’ will be. We can create a sense of safety by quickly establishing new routines that our students can count on and orient around. This will help to produce a rhythm to their days and can offer a sense of predictability in these unpredictable times.&lt;/p&gt;\n                            &lt;p&gt;&lt;strong&gt;Release&lt;/strong&gt;&lt;/p&gt;\n                            &lt;p&gt;Our students’ emotions will be stirred up. And we know that when emotions get stirred up, they need somewhere to go. Finding healthy ways to pre-emptively channel this emotional energy for our students can help to alleviate dangerous or disruptive eruptions. Integrating daily outlets for release can be especially helpful for supporting students to get out frustration before it leads to outbursts of aggression.&lt;/p&gt;\n                            &lt;p&gt;These outlets can also help students to reflect on and express their feelings in ways that don’t make them feel self-conscious. The beauty of this practice is that we don’t even have to know what is specifically going on for a child. We are simply facilitating a way for the emotion to be expressed and released indirectly in a natural way—whether through music, physical movement, stories or storytelling, writing, poetry, drama, art, or even simply being outdoors. All of these outlets are powerful because they help us come closer to our feelings and to experiencing a sense of release and emotional rest.&lt;/p&gt;\n                            &lt;p&gt;Going back to school during this time will not be easy. We will need to be creative and think outside the box. We may need to stretch muscles we never knew we had. But it may be helpful to remember that this is not a time to focus on outcome and performance, or getting ahead or even catching up. Shifting our attention to matters of the heart will help our students feel safe. This is what will set the stage for learning to happen – when children are ready.&lt;/p&gt;\n                            &lt;p&gt;In the meantime, let’s be patient with our students and ourselves. We are all in this together.&lt;/p&gt;', '2022-07-21 08:24:52', '2022-09-26 06:08:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cancel_courses`
--

CREATE TABLE `cancel_courses` (
  `requestId` bigint(20) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_courses_history`
--

CREATE TABLE `cancel_courses_history` (
  `requestId` bigint(20) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT ' 	1=>''Approved'' | 0=>''Cancelled'' 	',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_students`
--

CREATE TABLE `cancel_students` (
  `stuCourseId` bigint(20) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `userType` enum('1','2') NOT NULL COMMENT '1=Student, 2=Teacher ',
  `userId` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_students_history`
--

CREATE TABLE `cancel_students_history` (
  `stuCourseId` bigint(20) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `userType` enum('1','2') NOT NULL COMMENT '1=Student, 2=Teacher ',
  `userId` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '1=>''Approved'' | 0=>''Cancelled'' 	',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `change_instructor`
--

CREATE TABLE `change_instructor` (
  `queryId` bigint(20) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` int(11) NOT NULL,
  `reasonId` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `change_instructor_history`
--

CREATE TABLE `change_instructor_history` (
  `queryId` bigint(20) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` int(11) NOT NULL,
  `reasonId` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '1=>''Approved'' |\r\n0=>''Cancelled'' ',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `chapterId` bigint(20) NOT NULL,
  `subjectId` int(11) NOT NULL DEFAULT '0' COMMENT 'PK of subjects',
  `chapterNumber` varchar(255) DEFAULT NULL,
  `chapterName` varchar(255) DEFAULT NULL,
  `objectives` text,
  `summary` text,
  `chapterImage` varchar(255) DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL,
  `totalHours` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1-Active,0-Inactive',
  `created_by` enum('admin','instructor') NOT NULL DEFAULT 'admin',
  `creator_id` int(11) NOT NULL,
  `approve_status` enum('approved','forbidden') NOT NULL DEFAULT 'forbidden',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`chapterId`, `subjectId`, `chapterNumber`, `chapterName`, `objectives`, `summary`, `chapterImage`, `cost`, `totalHours`, `status`, `created_by`, `creator_id`, `approve_status`, `created`, `updated`) VALUES
(13, 15, '01', 'Basic of SEO', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '63c011164503e.jpg', 20.00, '3', 1, 'admin', 0, 'forbidden', '2023-01-12 13:54:30', '2023-01-12 13:54:58'),
(14, 15, '02', 'SEO Types', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '637e337ae9052.jpg', 15.00, '6', 0, 'admin', 0, 'forbidden', '2023-01-12 13:55:05', '2023-01-12 13:55:35'),
(15, 14, '01', 'Resources, energy, and waste', '&lt;p&gt;This point has important implications for the task of understanding \r\nsustainable development, because much of the confusion about the meaning\r\n of the term \'sustainable development\' arises because people hold very \r\ndifferent ideas about the meaning of \'development\' (Adams 2009).&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;', '&lt;p&gt;This point has important implications for the task of understanding sustainable development, because much of the confusion about the meaning of the term \'sustainable development\' arises because people hold very different ideas about the meaning of \'development\' (Adams 2009).&lt;br&gt;&lt;/p&gt;', '63c012310455a.jpg', 50.00, '10', 1, 'admin', 0, 'approved', '2023-01-12 13:59:13', '2023-01-12 13:59:13'),
(16, 14, '02', 'Social Structure', '&lt;p&gt;This point has important implications for the task of understanding \r\nsustainable development, because much of the confusion about the meaning\r\n of the term \'sustainable development\' arises because people hold very \r\ndifferent ideas about the meaning of \'development\' (Adams 2009).&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;', '&lt;p&gt;This point has important implications for the task of understanding sustainable development, because much of the confusion about the meaning of the term \'sustainable development\' arises because people hold very different ideas about the meaning of \'development\' (Adams 2009).&lt;br&gt;&lt;/p&gt;', 'become-an-instructor-help-section-image.png', 20.00, '8', 1, 'admin', 0, 'approved', '2023-01-12 13:59:42', '2023-01-12 14:06:07'),
(17, 17, '', 'Regan Bradshaw', '&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/p&gt;', '&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/p&gt;', '63c0152ba784b.jpg', 20.00, '6', 1, 'instructor', 6, 'forbidden', '2023-01-12 14:11:55', '2023-01-12 14:11:55'),
(18, 17, '', 'Mastering Data Modeling Fundamentals', '&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/p&gt;', '&lt;p&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/p&gt;', '63c015beabdbe.jpg', 30.00, '6', 1, 'instructor', 6, 'forbidden', '2023-01-12 14:14:22', '2023-01-12 14:14:22'),
(19, 16, '', 'Sand Painting', '&lt;p&gt;In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;\r\n&lt;p&gt;By the end of the course, you&amp;rsquo;ll be all set to not only put these principles to work, but also to make the key data modeling and design decisions required by the &amp;ldquo;art&amp;rdquo; of data modeling that transcend the nuts-and-bolts techniques and design patterns.&lt;/p&gt;', '&lt;p&gt;In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;\r\n&lt;p&gt;By the end of the course, you&amp;rsquo;ll be all set to not only put these principles to work, but also to make the key data modeling and design decisions required by the &amp;ldquo;art&amp;rdquo; of data modeling that transcend the nuts-and-bolts techniques and design patterns.&lt;/p&gt;', '63c0166589532.jpg', 60.00, '10', 1, 'instructor', 6, 'forbidden', '2023-01-12 14:17:09', '2023-01-12 14:17:09'),
(20, 18, '1', 'Python', '&lt;p&gt;Create fully functional Python programs&lt;/p&gt;&lt;p&gt;Understand user input&lt;/p&gt;&lt;p&gt;Learn about loop structures and conditionals&lt;/p&gt;&lt;p&gt;Correctly execute operations in Python&lt;/p&gt;&lt;p&gt;Work with Python file handling&lt;/p&gt;&lt;p&gt;Create and modify data structures in Python&lt;/p&gt;&lt;p&gt;Manipulate strings and data&lt;/p&gt;', '&lt;div data-purpose=&quot;safely-set-inner-html:description:description&quot;&gt;&lt;p&gt;&lt;strong&gt;Do you want to become a programmer?&lt;/strong&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Do you want to be able to create games, work with files, manipulate data, and much more?&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;If you want to learn programming or are learning Python for the first time, then you\'ve come to the right place!&lt;/p&gt;&lt;p&gt;Python is a &lt;strong&gt;powerful, modern&lt;/strong&gt;\r\n programming language that has the capabilities required for experienced\r\n programmers, while being easy enough for beginners to learn. Python is a\r\n &lt;strong&gt;well-developed, stable, and fun&lt;/strong&gt; programming language that is suitable for complex and simple development projects. Programmers love Python because of how &lt;strong&gt;simple and easy&lt;/strong&gt; it is to use.&lt;/p&gt;&lt;p&gt;This course has &lt;strong&gt;everything you need&lt;/strong&gt;\r\n to get started with Python. We\'ll first start with the basics of Python\r\n - learning about strings, variables, and data types. Then, we\'ll move \r\non to loops and conditionals. Once we\'re done with that, we\'ll learn \r\nabout functions and files in Python. All of this will culminate towards &lt;strong&gt;building a fun game &lt;/strong&gt;using the concepts we\'ve learned in Python. The entire course is filled with exercises that &lt;strong&gt;challenge you&lt;/strong&gt; so that you get the best experience possible.&lt;/p&gt;&lt;p&gt;I hope you\'re excited to dive into Python with this course. So what are you waiting for?&lt;strong&gt; Let\'s get started!&lt;/strong&gt;&lt;/p&gt;&lt;/div&gt;', '63c6e81def049.png', 15.00, '12', 1, 'admin', 0, 'approved', '2023-01-17 18:25:33', '2023-01-17 18:25:33'),
(21, 19, '', 'Grid Tie Solar', '&lt;p&gt;Test&lt;/p&gt;', '&lt;p&gt;Test&lt;/p&gt;', '63d0d511ade64.jpg', 1000.00, '40', 1, 'instructor', 13, 'approved', '2023-01-25 07:06:57', '2023-01-25 07:08:20'),
(22, 20, '', 'Transformer', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test&lt;/p&gt;', '63d0d5dc5e707.png', 1000.00, '40', 1, 'instructor', 13, 'approved', '2023-01-25 07:10:20', '2023-01-25 07:10:36'),
(23, 21, '', 'Magnetic Field', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;Test&lt;/p&gt;', '63d0d8763881c.png', 2000.00, '80', 1, 'instructor', 13, 'approved', '2023-01-25 07:21:26', '2023-01-25 07:21:48'),
(24, 20, '', 'Magnetic Field', '&lt;p&gt;Test&lt;/p&gt;', '&lt;p&gt;Test&lt;/p&gt;', '642d4e650ee67.png', 20.00, '6', 1, 'instructor', 13, 'forbidden', '2023-04-05 10:33:09', '2023-04-05 10:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_carriculum_media`
--

CREATE TABLE `chapter_carriculum_media` (
  `mediaId` bigint(20) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `chapterId` int(11) NOT NULL,
  `ordering` varchar(255) NOT NULL,
  `mediaType` enum('image','video','audio','document') NOT NULL,
  `mediaFile` varchar(255) NOT NULL,
  `mediaOgName` varchar(255) NOT NULL,
  `fileSize` varchar(255) NOT NULL,
  `userType` enum('admin','instructor') NOT NULL DEFAULT 'admin',
  `userId` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapter_carriculum_media`
--

INSERT INTO `chapter_carriculum_media` (`mediaId`, `subjectId`, `chapterId`, `ordering`, `mediaType`, `mediaFile`, `mediaOgName`, `fileSize`, `userType`, `userId`, `created`) VALUES
(308, 2, 2, '2', 'image', 'carriculum_541669265193.jpg', '2_11zon', '1634024', 'admin', 1, '2022-11-24 05:46:33'),
(309, 2, 2, '1', 'image', 'carriculum_491669265193.jpg', '1_11zon', '1074276', 'admin', 1, '2022-11-24 05:46:33'),
(310, 12, 12, '1', 'image', 'carriculum_871669265496.jpg', 'courses-1', '16225', 'admin', 2, '2022-11-24 05:51:36'),
(311, 12, 12, '2', 'image', 'carriculum_471669265496.jpg', 'courses-3', '13435', 'admin', 2, '2022-11-24 05:51:36'),
(313, 12, 12, '3', 'document', 'carriculum_851671803653.pdf', 'Learn TEC', '102265', 'admin', 2, '2022-12-23 14:54:13'),
(314, 21, 23, '1', 'video', 'carriculum_771674635327.mp4', 'VideoOfButterfly', '4478380', 'admin', 13, '2023-01-25 08:28:47'),
(315, 20, 22, '1', 'video', 'carriculum_301674635368.mp4', 'VideoOfButterfly', '4478380', 'admin', 13, '2023-01-25 08:29:28'),
(316, 20, 24, '1', 'image', 'carriculum_711680690808.jpg', 'Ad Banner', '79010', 'admin', 13, '2023-04-05 10:33:28'),
(317, 20, 24, '2', 'image', 'carriculum_101680690808.jpg', 'Advertising-Banners-2', '120528', 'admin', 13, '2023-04-05 10:33:28'),
(318, 17, 18, '1', 'image', 'carriculum_431681112523.jpeg', 'new', '34154', 'admin', 6, '2023-04-10 07:42:03');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `pageId` bigint(20) NOT NULL,
  `sectionTitle` varchar(255) NOT NULL,
  `cmsTitle` varchar(100) DEFAULT NULL,
  `required_link` enum('1','0') NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `page_slug` varchar(255) NOT NULL,
  `required_textarea` enum('1','0') NOT NULL DEFAULT '0',
  `required_textarea_plugins` enum('1','0') NOT NULL DEFAULT '0',
  `content` longtext,
  `required_image` enum('1','0') NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`pageId`, `sectionTitle`, `cmsTitle`, `required_link`, `link`, `page_slug`, `required_textarea`, `required_textarea_plugins`, `content`, `required_image`, `image`, `created`, `modified`) VALUES
(1, 'Start to Success', 'START TO SUCCESS', '0', '', 'home', '1', '0', 'Access To Courses from Instructors', '0', '', '2021-07-05 10:51:22', '2022-10-20 05:13:44'),
(2, 'Next Level', 'Take your learning organization to the next level.', '0', NULL, 'home', '1', '0', 'Tomorrow is our \"When I Grow Up\" Spirit Day!', '1', 'cms_900421665400928.png', '2021-07-05 10:51:33', '2022-10-20 05:22:10'),
(3, 'Promotional Point-1', '1 to 1 interaction with Instructors', '0', NULL, 'home', '0', '0', NULL, '1', 'cms_303951673877417.jpg', '2021-07-05 10:51:22', '2023-01-16 13:56:57'),
(14, 'Watch video intro', 'Improving Lives Through Learning', '1', 'https://www.youtube-nocookie.com/embed/Ga6RYejo6Hk', 'about-us', '0', '0', NULL, '1', 'cms_837741666246275.jpg', '2022-08-01 11:49:34', '2022-10-20 08:12:45'),
(19, 'We\'re here to help', 'We\'re here to help', '0', NULL, 'about-us', '1', '0', 'Our Instructor Support Team is here for you 24/7 to help you through your course creation needs. Use our Teaching Center, a resource center to help you through the process.This community group is always on, always there, and always helpful.\r\n', '1', 'cms_614961666248133.png', '2021-07-05 10:51:22', '2022-10-20 06:42:13'),
(27, 'Promotional Point-2', 'Certified Professionals', '0', NULL, 'home', '0', '0', NULL, '1', 'cms_998661673877524.jpg', '2021-07-05 10:51:22', '2023-01-16 13:58:44'),
(28, 'Promotional Points-3', 'Live Interactive Sessions', '0', NULL, 'home', '0', '0', NULL, '1', 'cms_888381673877670.jpg', '2021-07-05 10:51:22', '2023-01-16 14:01:37'),
(29, 'Promotional Points-4', 'Flexible Timings ', '0', NULL, 'home', '0', '0', NULL, '1', 'cms_600141673877831.jpg', '2021-07-05 10:51:22', '2023-01-16 14:03:51'),
(30, 'Let Us Help', 'Let Us Help', '1', 'courselist', 'home', '1', '0', 'Finding Your Right Courses', '0', '', '2021-07-05 10:51:33', '2022-10-20 05:53:07'),
(31, 'Testimonial Section', 'People Say About E-Learning Online', '0', '', 'home', '1', '0', 'One-stop solution for any eLearning center, online courses. People love e-Learning Online because they can create their sites with ease here.', '0', '', '2021-07-05 10:51:33', '2022-10-10 11:50:45'),
(32, 'Become An Instructor', 'Become An Instructor', '0', NULL, 'home', '1', '0', 'Top instructors from around the world teach millions of students on e-Learning Online.\r\n\r\n', '1', 'cms_505611666245657.png', '2021-07-05 10:51:33', '2022-10-20 06:00:57'),
(33, 'Access To Education', 'Access To Education', '0', NULL, 'home', '1', '0', 'Create an account to receive our newsletter, course recommendations and promotions.\r\n', '1', 'cms_259191666245841.png', '2021-07-05 10:51:33', '2022-10-20 06:04:01'),
(34, 'Join Instructor Team', 'Join Instructor Team', '0', NULL, 'about-us', '0', '0', NULL, '0', '', '2021-07-05 10:51:22', '2022-10-20 06:44:21'),
(35, 'We\'re here to help', 'We\'re here to help', '0', NULL, 'become-instructor', '1', '0', 'Our Instructor Support Team is here for you 24/7 to help you through your course creation needs. Use our Teaching Center, a resource center to help you through the process.This community group is always on, always there, and always helpful.\r\n', '1', 'cms_156641666252316.png', '2021-07-05 10:51:22', '2022-10-20 07:51:56'),
(36, 'How to Become an Instructor - Tab 1', 'Become an Instructor', '0', NULL, 'become-instructor', '1', '1', ' <h3 class=\"become-an-instructor__main-title\">Become an Instructor</h3>\r\n\r\n                                        <div class=\"become-an-instructor__caption\">\r\n                                            <h4 class=\"become-an-instructor__title\">Plan your course</h4>\r\n                                            <p>Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egetnval</p>\r\n                                        </div>\r\n\r\n                                        <div class=\"become-an-instructor__caption\">\r\n                                            <h4 class=\"become-an-instructor__title\">How we help you</h4>\r\n                                            <p>Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egeeque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egetnval</p>\r\n                                        </div>', '1', 'cms_148941666251638.png', '2021-07-05 10:51:22', '2022-10-20 07:40:38'),
(37, 'How to Become an Instructor - Tab 2', 'Instructor Rules', '0', NULL, 'become-instructor', '1', '1', ' <h3 class=\"become-an-instructor__main-title\">Become an Instructor</h3>\r\n\r\n                                        <div class=\"become-an-instructor__caption\">\r\n                                            <h4 class=\"become-an-instructor__title\">Plan your course</h4>\r\n                                            <p>Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egetnval</p>\r\n                                        </div>\r\n\r\n                                        <div class=\"become-an-instructor__caption\">\r\n                                            <h4 class=\"become-an-instructor__title\">How we help you</h4>\r\n                                            <p>Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egeeque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egetnval</p>\r\n                                        </div>', '1', 'cms_448281666252043.png', '2021-07-05 10:51:22', '2022-10-20 07:47:23'),
(38, 'How to Become an Instructor - Tab-3', 'Start with Courses', '0', NULL, 'become-instructor', '1', '1', ' <h3 class=\"become-an-instructor__main-title\">Become an Instructor</h3>\r\n\r\n                                        <div class=\"become-an-instructor__caption\">\r\n                                            <h4 class=\"become-an-instructor__title\">Plan your course</h4>\r\n                                            <p>Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egetnval</p>\r\n                                        </div>\r\n\r\n                                        <div class=\"become-an-instructor__caption\">\r\n                                            <h4 class=\"become-an-instructor__title\">How we help you</h4>\r\n                                            <p>Neque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egeeque convallis a cras semper auctor. Libero id faucibus nisl tincidunt egetnvallis a cras semper auctonvallis a cras semper aucto. Neque convallis a cras semper auctor. Liberoe convallis a cras semper atincidunt egetnval</p>\r\n                                        </div>', '1', 'cms_782521666252131.png', '2021-07-05 10:51:22', '2022-10-20 07:48:51'),
(39, 'Become an Instructor-Start', 'Become an Instructor', '0', NULL, 'become-instructor', '1', '0', 'Top instructors from around the world teach millions of students on E-Learning.\r\n', '1', 'cms_959061666250084.png', '2021-07-05 10:51:22', '2022-10-20 07:14:44'),
(40, 'Become an Instructor Tab Title', 'How to Become an Instructor', '0', NULL, 'become-instructor', '0', '0', NULL, '0', '', '2021-07-05 10:51:22', '2022-10-20 07:33:15'),
(41, 'Become an Instructor last section', 'Become an Instructor Today', '0', NULL, 'become-instructor', '1', '0', 'Join the world\'s largest online learning marketplace', '0', '', '2021-07-05 10:51:22', '2022-10-20 07:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseId` bigint(20) NOT NULL,
  `courseName` varchar(255) DEFAULT NULL,
  `userId` int(11) NOT NULL COMMENT '0-Admin',
  `descriptions` longtext,
  `image` varchar(100) DEFAULT NULL,
  `created_by` enum('admin','instructor') NOT NULL DEFAULT 'admin',
  `creator_id` int(11) NOT NULL,
  `approve_status` enum('approved','forbidden') NOT NULL DEFAULT 'forbidden',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseId`, `courseName`, `userId`, `descriptions`, `image`, `created_by`, `creator_id`, `approve_status`, `created`, `updated`, `status`) VALUES
(16, 'Course for MongoDB', 1, '&lt;p style=&quot;color: rgb(51, 51, 51); font-family: Gordita, Arial, Helvetica, sans-serif; font-size: 14px;&quot;&gt;In\r\n this course, I take you from the fundamentals and concepts of data \r\nmodeling all the way through a number of best practices and techniques \r\nthat you’ll need to build data models in your organization. You’ll find \r\nmany examples that clearly demonstrate the key concepts and techniques \r\ncovered throughout the course.&lt;/p&gt;&lt;p style=&quot;margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Gordita, Arial, Helvetica, sans-serif; font-size: 14px;&quot;&gt;By\r\n the end of the course, you’ll be all set to not only put these \r\nprinciples to work, but also to make the key data modeling and design \r\ndecisions required by the “art” of data modeling that transcend the \r\nnuts-and-bolts techniques and design patterns.&lt;/p&gt;&lt;p&gt;&lt;/p&gt;', '63c014517da62.jpg', 'admin', 1, 'approved', '2023-01-12 14:08:17', '2023-01-12 14:08:17', '1'),
(17, 'Course for Node js', 6, '&lt;p&gt;In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;\r\n&lt;p&gt;By the end of the course, you&amp;rsquo;ll be all set to not only put these principles to work, but also to make the key data modeling and design decisions required by the &amp;ldquo;art&amp;rdquo; of data modeling that transcend the nuts-and-bolts techniques and design patterns.&lt;/p&gt;', '63c0169b9b080.jpg', 'instructor', 6, 'approved', '2023-01-12 14:18:03', '2023-01-12 14:18:03', '1'),
(18, 'Python for Beginners', 0, '&lt;div class=&quot;component-margin what-you-will-learn--what-will-you-learn--1nBIT&quot;&gt;\r\n&lt;h2 class=&quot;ud-heading-xl what-you-will-learn--title--2ztwE&quot;&gt;What you\'ll learn&lt;/h2&gt;\r\n&lt;div class=&quot;what-you-will-learn--content-spacing--3n5NU&quot;&gt;\r\n&lt;ul class=&quot;ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--eiLce what-you-will-learn--objectives-list-two-column-layout--rZLJy&quot;&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Create fully functional Python programs&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Understand user input&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Learn about loop structures and conditionals&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Correctly execute operations in Python&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Work with Python file handling&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Create and modify data structures in Python&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;div class=&quot;ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm&quot; data-purpose=&quot;objective&quot;&gt;\r\n&lt;div class=&quot;ud-block-list-item-content&quot;&gt;&lt;span class=&quot;what-you-will-learn--objective-item--3b4zX&quot;&gt;Manipulate strings and data&lt;/span&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;', '63c6e78187d8e.jpg', 'instructor', 11, 'approved', '2023-01-17 18:22:57', '2023-01-17 13:09:12', '1'),
(19, 'Energy', 0, '&lt;p&gt;Electrical + Solar&lt;/p&gt;', '63d0d6b02cb58.jpg', 'instructor', 13, 'approved', '2023-01-25 07:13:52', '2023-04-21 06:45:04', '1');

-- --------------------------------------------------------

--
-- Table structure for table `courses_chapters_bak`
--

CREATE TABLE `courses_chapters_bak` (
  `couChaId` bigint(20) NOT NULL,
  `courseId` int(11) NOT NULL COMMENT 'PK of courses',
  `chapterId` int(11) NOT NULL COMMENT 'PK of chapters',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_chapters`
--

CREATE TABLE `course_chapters` (
  `courseDetailId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `level` enum('beginner','intermediate','advanced') NOT NULL,
  `chapterId` int(11) NOT NULL,
  `subjectId` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_chapters`
--

INSERT INTO `course_chapters` (`courseDetailId`, `courseId`, `level`, `chapterId`, `subjectId`, `created`, `updated`) VALUES
(137, 16, 'beginner', 14, 15, '2023-01-12 14:08:17', '2023-01-12 14:08:17'),
(138, 16, 'intermediate', 15, 14, '2023-01-12 14:08:17', '2023-01-12 14:08:17'),
(139, 17, 'beginner', 18, 17, '2023-01-12 14:18:03', '2023-01-12 14:18:03'),
(140, 17, 'beginner', 17, 17, '2023-01-12 14:18:03', '2023-01-12 14:18:03'),
(141, 17, 'intermediate', 19, 16, '2023-01-12 14:18:03', '2023-01-12 14:18:03'),
(142, 17, 'intermediate', 15, 14, '2023-01-12 14:18:03', '2023-01-12 14:18:03'),
(147, 18, 'beginner', 20, 18, '2023-01-17 18:39:12', '2023-01-17 18:39:12'),
(166, 19, 'beginner', 22, 20, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(167, 19, 'advanced', 21, 19, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(168, 19, 'advanced', 22, 20, '2023-04-21 12:15:04', '2023-04-21 12:15:04');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructors`
--

CREATE TABLE `course_instructors` (
  `courseInsId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `level` text NOT NULL,
  `instructorId` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_instructors`
--

INSERT INTO `course_instructors` (`courseInsId`, `courseId`, `level`, `instructorId`, `created`, `updated`) VALUES
(101, 16, 'beginner', 6, '2023-01-12 14:08:17', '2023-01-12 14:08:17'),
(102, 16, 'intermediate', 6, '2023-01-12 14:08:17', '2023-01-12 14:08:17'),
(103, 17, 'beginner', 6, '2023-01-12 14:18:03', '2023-01-12 14:18:03'),
(104, 17, 'intermediate', 6, '2023-01-12 14:18:03', '2023-01-12 14:18:03'),
(109, 18, 'beginner', 11, '2023-01-17 18:39:12', '2023-01-17 18:39:12'),
(148, 19, 'beginner', 13, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(149, 19, 'beginner', 8, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(150, 19, 'beginner', 7, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(151, 19, 'beginner', 6, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(152, 19, 'advanced', 13, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(153, 19, 'advanced', 9, '2023-04-21 12:15:04', '2023-04-21 12:15:04'),
(154, 19, 'advanced', 7, '2023-04-21 12:15:04', '2023-04-21 12:15:04');

-- --------------------------------------------------------

--
-- Table structure for table `course_level_details`
--

CREATE TABLE `course_level_details` (
  `crsLvlId` bigint(20) NOT NULL,
  `courseId` bigint(20) NOT NULL,
  `level` enum('beginner','intermediate','advanced') NOT NULL COMMENT '''beginner'',''intermediate'',''advanced''',
  `intro_video` varchar(255) NOT NULL,
  `descriptions` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1= ''active'' | 0 = ''inactive'' 	',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_level_details`
--

INSERT INTO `course_level_details` (`crsLvlId`, `courseId`, `level`, `intro_video`, `descriptions`, `image`, `status`, `created`, `updated`) VALUES
(79, 16, 'beginner', '', '<p style=\"color: rgb(51, 51, 51); font-family: Gordita, Arial, Helvetica, sans-serif; font-size: 14px;\">In\r\n this course, I take you from the fundamentals and concepts of data \r\nmodeling all the way through a number of best practices and techniques \r\nthat you’ll need to build data models in your organization. You’ll find \r\nmany examples that clearly demonstrate the key concepts and techniques \r\ncovered throughout the course.</p><p style=\"margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Gordita, Arial, Helvetica, sans-serif; font-size: 14px;\">By\r\n the end of the course, you’ll be all set to not only put these \r\nprinciples to work, but also to make the key data modeling and design \r\ndecisions required by the “art” of data modeling that transcend the \r\nnuts-and-bolts techniques and design patterns.</p><p></p>', '63c014517f257.jpg', '1', '2023-01-12 14:08:17', '2023-01-12 19:38:17'),
(80, 16, 'intermediate', '', '<p style=\"color: rgb(51, 51, 51); font-family: Gordita, Arial, Helvetica, sans-serif; font-size: 14px;\">In\r\n this course, I take you from the fundamentals and concepts of data \r\nmodeling all the way through a number of best practices and techniques \r\nthat you’ll need to build data models in your organization. You’ll find \r\nmany examples that clearly demonstrate the key concepts and techniques \r\ncovered throughout the course.</p><p style=\"margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Gordita, Arial, Helvetica, sans-serif; font-size: 14px;\">By\r\n the end of the course, you’ll be all set to not only put these \r\nprinciples to work, but also to make the key data modeling and design \r\ndecisions required by the “art” of data modeling that transcend the \r\nnuts-and-bolts techniques and design patterns.</p><p></p>', '63c014517fd50.jpg', '1', '2023-01-12 14:08:17', '2023-01-12 19:38:17'),
(81, 17, 'beginner', '', '<p>In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&rsquo;ll need to build data models in your organization. You&rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.</p>\r\n<p>By the end of the course, you&rsquo;ll be all set to not only put these principles to work, but also to make the key data modeling and design decisions required by the &ldquo;art&rdquo; of data modeling that transcend the nuts-and-bolts techniques and design patterns.</p>', '63c0169b9c421.jpg', '1', '2023-01-12 14:18:03', '2023-01-12 19:48:03'),
(82, 17, 'intermediate', '', '<p>In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&rsquo;ll need to build data models in your organization. You&rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.</p>\r\n<p>By the end of the course, you&rsquo;ll be all set to not only put these principles to work, but also to make the key data modeling and design decisions required by the &ldquo;art&rdquo; of data modeling that transcend the nuts-and-bolts techniques and design patterns.</p>', '63c0169b9d095.jpg', '1', '2023-01-12 14:18:03', '2023-01-12 19:48:03'),
(87, 18, 'beginner', '', '<p>test</p>', '', '1', '2023-01-17 18:39:12', '2023-01-18 00:09:12'),
(100, 19, 'beginner', '', '<p><strong style=\"margin: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</span><br></p>', '63d0d6b02d711.jpg', '1', '2023-04-21 12:15:04', '2023-04-21 17:45:04'),
(101, 19, 'advanced', '', '<p>test</p>', '63d0d6b02e1e2.png', '1', '2023-04-21 12:15:04', '2023-04-21 17:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `course_review`
--

CREATE TABLE `course_review` (
  `reviewId` bigint(20) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=''active'',0=''inactive''',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` varchar(500) CHARACTER SET utf8 NOT NULL,
  `answer` varchar(800) CHARACTER SET utf8 NOT NULL,
  `status` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `status`, `created`, `updated`) VALUES
(1, 'Test FAQ', 'Test answer...', 1, '2022-09-02 07:11:59', '2022-09-02 05:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_schedule_time`
--

CREATE TABLE `instructor_schedule_time` (
  `scheduleTimeId` bigint(20) NOT NULL,
  `instructorId` bigint(20) NOT NULL,
  `weekday` varchar(255) NOT NULL,
  `fromTime` time NOT NULL,
  `toTime` time NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor_schedule_time`
--

INSERT INTO `instructor_schedule_time` (`scheduleTimeId`, `instructorId`, `weekday`, `fromTime`, `toTime`, `updated`) VALUES
(443, 6, 'Monday', '10:00:00', '12:00:00', '2023-01-12 14:20:39'),
(444, 6, 'Wednesday', '10:00:00', '12:00:00', '2023-01-12 14:20:39'),
(445, 6, 'Friday', '10:00:00', '12:00:00', '2023-01-12 14:20:39'),
(450, 11, 'Sunday', '08:00:00', '11:00:00', '2023-01-18 00:00:49'),
(451, 11, 'Saturday', '08:00:00', '11:00:00', '2023-01-18 00:00:49'),
(452, 11, 'Tuesday', '08:00:00', '11:00:00', '2023-01-17 18:40:23'),
(453, 11, 'Wednesday', '08:00:00', '11:00:00', '2023-01-17 18:40:23'),
(454, 13, 'Monday', '08:00:00', '10:00:00', '2023-01-25 07:47:35'),
(455, 13, 'Tuesday', '08:00:00', '10:00:00', '2023-01-25 07:47:35'),
(456, 13, 'Wednesday', '08:00:00', '10:00:00', '2023-01-25 07:47:35'),
(457, 13, 'Thursday', '08:00:00', '10:00:00', '2023-01-25 07:47:35'),
(458, 13, 'Friday', '08:00:00', '10:00:00', '2023-01-25 07:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, '15ade0c4b9de180db94f5b367936b978', 0, 0, 0, NULL, '2020-11-17 13:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lessonId` bigint(20) NOT NULL,
  `chapterId` int(11) NOT NULL COMMENT 'PK of chapters',
  `lessonNumber` varchar(255) DEFAULT NULL,
  `lessonName` varchar(255) DEFAULT NULL,
  `objectives` text,
  `syllabus` longtext,
  `lessonImage` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL COMMENT 'in mins',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(3) NOT NULL COMMENT '0-Inactive 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lessonId`, `chapterId`, `lessonNumber`, `lessonName`, `objectives`, `syllabus`, `lessonImage`, `duration`, `created`, `updated`, `status`) VALUES
(1, 1, 'BUSINESS ENTITIES AND RELATIONSHIPS', 'DATA MODELS DESCRIBE BUSINESS ENTITIES AND RELATIONSHIPS', '&lt;p&gt;&lt;span style=&quot;color: rgb(58, 58, 58); font-family: Lato, sans-serif; font-size: 18px;&quot;&gt;Data models are made up of entities, which are the objects or concepts we want to track data about, and they become the tables in a database. Products, vendors, and customers are all examples of potential entities in a data model. Entities have attributes, which are details we want to track about entities—you can think of attributes as the columns in a table. If we have a product entity, the product name could be an attribute.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '&lt;h3 class=&quot;heading-sc-idhpcb-2 bbmIuI rich-heading__HeadingLato-sc-bhgn0w-0 gDaxjD&quot; style=&quot;box-sizing: inherit; font-size: 18px; margin: 40px 0px 16px; color: rgb(58, 58, 58); font-family: Lato, sans-serif; font-weight: bold; text-rendering: optimizelegibility; line-height: 32px; text-transform: uppercase;&quot;&gt;DATA MODELING SHOULD ENFORCE DATA INTEGRITY&lt;/h3&gt;&lt;p class=&quot;text__StyledText-sc-1dxuv57-0 hLSUbt rich-paragraph__StyledText-sc-12jbmhp-0 defSlX&quot; color=&quot;midnightBlack&quot; font-weight=&quot;400&quot; style=&quot;box-sizing: inherit; margin-right: 0px; margin-bottom: 24px; margin-left: 0px; color: rgb(58, 58, 58); font-size: 18px; line-height: 36px; font-family: Lato, sans-serif;&quot;&gt;When we talk with clients about leveraging their data, data integrity is a crucial prerequisite. Before companies can start using their data to make decisions, they need to be able to trust that the data sets are accurate and reliable. In data modeling, there are two kinds of rules that are foundational to maintaining data integrity—entity integrity and referential integrity.&lt;/p&gt;&lt;p class=&quot;text__StyledText-sc-1dxuv57-0 hLSUbt rich-paragraph__StyledText-sc-12jbmhp-0 defSlX&quot; color=&quot;midnightBlack&quot; font-weight=&quot;400&quot; style=&quot;box-sizing: inherit; margin-right: 0px; margin-bottom: 24px; margin-left: 0px; color: rgb(58, 58, 58); font-size: 18px; line-height: 36px; font-family: Lato, sans-serif;&quot;&gt;Entity integrity means that the data within a single entity or table are reliable. The use of primary keys is an essential step toward entity integrity. Primary keys are unique identifiers, such as product ID numbers, that serve the purpose of identifying a particular record and preventing data duplication. There are three parts to the entity integrity rule:&lt;/p&gt;&lt;ul style=&quot;box-sizing: inherit; margin-bottom: 1.45rem; margin-left: 1.45rem; list-style-position: outside; list-style-image: none; color: rgb(58, 58, 58); font-family: Lato, sans-serif; font-size: 16px;&quot;&gt;&lt;li class=&quot;rich-list-item__StyledRichListItem-sc-nw5q45-0 ioXOOA&quot; style=&quot;box-sizing: inherit; margin-bottom: 0px;&quot;&gt;&lt;p class=&quot;text__StyledText-sc-1dxuv57-0 hLSUbt rich-paragraph__StyledText-sc-12jbmhp-0 defSlX&quot; color=&quot;midnightBlack&quot; font-weight=&quot;400&quot; style=&quot;box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 18px; line-height: 36px;&quot;&gt;All entities should have a primary key.&lt;/p&gt;&lt;/li&gt;&lt;li class=&quot;rich-list-item__StyledRichListItem-sc-nw5q45-0 ioXOOA&quot; style=&quot;box-sizing: inherit; margin-bottom: 0px;&quot;&gt;&lt;p class=&quot;text__StyledText-sc-1dxuv57-0 hLSUbt rich-paragraph__StyledText-sc-12jbmhp-0 defSlX&quot; color=&quot;midnightBlack&quot; font-weight=&quot;400&quot; style=&quot;box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 18px; line-height: 36px;&quot;&gt;The values of all primary keys must be unique.&lt;/p&gt;&lt;/li&gt;&lt;li class=&quot;rich-list-item__StyledRichListItem-sc-nw5q45-0 ioXOOA&quot; style=&quot;box-sizing: inherit; margin-bottom: 0px;&quot;&gt;&lt;p class=&quot;text__StyledText-sc-1dxuv57-0 hLSUbt rich-paragraph__StyledText-sc-12jbmhp-0 defSlX&quot; color=&quot;midnightBlack&quot; font-weight=&quot;400&quot; style=&quot;box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 18px; line-height: 36px;&quot;&gt;The value of a primary key cannot be null.&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;', '62989ed86accf.jpg', '45', '2022-06-02 11:28:24', '2022-06-02 11:28:24', 1),
(2, 1, 'Relationship Between 01', 'DATA INTEGRITY', '&lt;p&gt;&lt;span style=&quot;color: rgb(58, 58, 58); font-family: Lato, sans-serif; font-size: 18px;&quot;&gt;Referential integrity means that the relationship between two entities or tables is reliable. The use of foreign keys is an essential step toward referential integrity. Foreign keys are the primary keys of one table that appear in a different table. The rule of referential integrity says that for any foreign key value in one table, there must be a matching primary key value in the referenced table.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span style=&quot;color: rgb(58, 58, 58); font-family: Lato, sans-serif; font-size: 18px;&quot;&gt;Dimensional data modeling can result in a design called a star schema, which has denormalized tables, and it is used for building reporting and analytical systems. Dimensional models are designed to be great at getting data out of a data warehouse and into the hands of business users. By storing data in a less normalized form, dimensional models make it much easier to query across many different tables. It’s worth noting that there are reasons for using a 3NF design, rather than a star schema, in a data warehouse. In modern data architecture, business intelligence tools often bridge the gap between multiple levels of normalization.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '62989f98199dc.jpg', '40', '2022-06-02 11:31:36', '2022-06-02 11:31:36', 1),
(3, 2, '290', 'Keaton Gutierrez', '', '', '62cc02b9a070b.jpg', 'Dolorem numquam offi', '2022-07-11 13:00:10', '2022-07-11 11:00:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `packageId` int(11) NOT NULL,
  `packageName` varchar(255) DEFAULT NULL,
  `packageDescription` text,
  `price` double DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'Monthly, Yearly',
  `currency` varchar(255) DEFAULT NULL,
  `currencySymbol` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `packageStatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1= Active, 0=InActive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`packageId`, `packageName`, `packageDescription`, `price`, `type`, `currency`, `currencySymbol`, `created`, `updated`, `packageStatus`) VALUES
(1, 'Starter', '&lt;p&gt;									Bill Monthly&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 10, 'Monthly', 'USD', '$', '2021-05-19 17:55:23', '2021-05-19 10:20:20', 1),
(2, 'Permium', '&lt;p&gt;									Bill Monthly&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 30, 'Monthly', 'USD', '$', '2021-05-19 18:01:45', '2022-06-02 09:59:31', 1),
(3, 'Advance', '&lt;p&gt;									Bill Yearly&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 700, 'Yearly', 'USD', '$', '2021-05-19 18:01:45', '2022-08-10 06:14:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `quesId` bigint(20) NOT NULL,
  `testId` int(11) NOT NULL COMMENT 'PK of Tests',
  `subjectId` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quesType` enum('List','Math','Image','Text') NOT NULL DEFAULT 'List',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0-Inactive, 1-Active',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`quesId`, `testId`, `subjectId`, `question`, `image`, `quesType`, `status`, `created`, `updated`) VALUES
(1, 1, NULL, 'What is Diode?', NULL, 'List', 1, '2021-09-17 10:26:33', '2021-09-17 10:26:33'),
(2, 1, NULL, 'Which Number comes inside the circle?', '2.jpg', 'List', 1, '2021-09-17 11:50:54', '2021-09-17 11:50:54'),
(3, 2, NULL, 'Which of the following organic groups are found in naturally occuring amino acids?', NULL, 'List', 1, '2021-09-17 12:13:03', '2021-09-17 12:13:03'),
(4, 2, NULL, 'Which letter replace the question mark?', '1.jpg', 'List', 1, '2021-09-17 12:15:03', '2021-09-17 12:15:03'),
(5, 1, NULL, 'The reactions of molecules', NULL, 'List', 1, '2021-09-17 12:33:45', '2021-09-17 12:33:45'),
(6, 1, NULL, 'Which of the following indicates that the pK of an acid is numerically equal to the pH of the solution when the molar concentration of the acid and its conjugate base are equal?', NULL, 'List', 1, '2021-09-17 12:35:27', '2021-09-17 12:35:27'),
(7, 0, NULL, 'The weakest section of a diamond riveting, is the section which passes through', '1565320703Field-Hockey.png', 'List', 1, '2021-10-06 13:22:51', '2021-10-06 13:22:51'),
(8, 4, NULL, 'The keyword used to transfer control from a function back to the calling function is', NULL, 'List', 1, '2021-10-06 13:25:37', '2021-10-06 13:25:37'),
(9, 6, 1, 'hjksahksdhkjsdhksjdhkjdshdshkjshksdhajksddsjsdkhdsjsdhkajsadjksa', 'images1.png', 'List', 1, '2021-11-27 13:01:00', '2021-11-27 13:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `questions_options`
--

CREATE TABLE `questions_options` (
  `optionId` bigint(20) NOT NULL,
  `quesId` int(11) NOT NULL COMMENT 'PK of questions',
  `optionText` text NOT NULL,
  `correctAns` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-Not 1-Yes',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions_options`
--

INSERT INTO `questions_options` (`optionId`, `quesId`, `optionText`, `correctAns`, `created`) VALUES
(1, 1, 'is the simplest of semiconductor devices', 0, '2021-09-17 10:26:33'),
(2, 1, 'has characteristics that closely match those of a simple switch', 0, '2021-09-17 10:26:33'),
(3, 1, 'is a two-terminal device', 0, '2021-09-17 10:26:33'),
(4, 1, 'All of the above', 1, '2021-09-17 10:26:33'),
(5, 2, '5', 0, '2021-09-17 11:50:54'),
(6, 2, '6', 0, '2021-09-17 11:50:54'),
(7, 2, '7', 0, '2021-09-17 11:50:54'),
(8, 2, 'None', 1, '2021-09-17 11:50:54'),
(9, 3, 'Guanidinium ion', 0, '2021-09-17 12:13:03'),
(10, 3, 'Indole', 0, '2021-09-17 12:13:03'),
(11, 3, 'Imidazole', 0, '2021-09-17 12:13:03'),
(12, 3, 'All of these', 1, '2021-09-17 12:13:03'),
(13, 4, 'Q', 0, '2021-09-17 12:15:03'),
(14, 4, 'None', 1, '2021-09-17 12:15:03'),
(15, 4, 'E', 0, '2021-09-17 12:15:03'),
(16, 4, 'T', 0, '2021-09-17 12:15:03'),
(17, 5, 'are the reactions of the functional groups', 1, '2021-09-17 12:33:46'),
(18, 5, 'are independent of the functional groups', 0, '2021-09-17 12:33:46'),
(19, 5, 'require an enzyme in all cases', 0, '2021-09-17 12:33:46'),
(20, 5, 'all of the above', 0, '2021-09-17 12:33:46'),
(21, 6, 'Michaelis-Menten equation', 0, '2021-09-17 12:35:27'),
(22, 6, 'Haldanes equation', 0, '2021-09-17 12:35:27'),
(23, 6, 'Henderson-Hasselbalch equation', 1, '2021-09-17 12:35:27'),
(24, 6, 'Hardy-Windberg law', 0, '2021-09-17 12:35:27'),
(25, 7, 'first row', 1, '2021-10-06 13:22:51'),
(26, 7, 'second row', 0, '2021-10-06 13:22:51'),
(27, 7, 'central raw', 0, '2021-10-06 13:22:51'),
(28, 7, 'one rivet hole of end row.', 0, '2021-10-06 13:22:51'),
(29, 8, 'switch', 0, '2021-10-06 13:25:37'),
(30, 8, 'goto', 0, '2021-10-06 13:25:37'),
(31, 8, 'go back', 0, '2021-10-06 13:25:37'),
(32, 8, 'return', 1, '2021-10-06 13:25:37'),
(33, 9, '(c) Why wind should blow?', 0, '2021-11-27 13:01:00'),
(34, 9, 'c', 1, '2021-11-27 13:01:00'),
(35, 9, 'd', 0, '2021-11-27 13:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quizId` bigint(20) NOT NULL,
  `quizName` varchar(255) DEFAULT NULL,
  `quizNumber` varchar(255) DEFAULT NULL,
  `chapterId` varchar(255) DEFAULT NULL COMMENT 'PK of Chapters',
  `lessonId` varchar(255) DEFAULT NULL COMMENT 'PK of Lessons',
  `instructions` text,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(3) NOT NULL COMMENT '0-Inactive 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizId`, `quizName`, `quizNumber`, `chapterId`, `lessonId`, `instructions`, `created`, `updated`, `status`) VALUES
(1, 'Quiz on Science: Biology', 'Biology Set I', '2', '2', '&lt;p&gt;&lt;span style=&quot;color: rgb(88, 88, 88); font-family: Roboto, Verdana, Geneva, sans-serif; font-size: 16px;&quot;&gt;Biology is the science of life that also deals with the physicochemical aspects of life. For the convenience of the study, it is divided into several branches including botany, zoology, morphology, etc. Let us solve an interesting quiz based on life science that will help in the preparation of competitive examinations and enhance knowledge.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '2021-10-01 13:15:54', '2021-10-01 13:15:54', 0),
(3, 'Quiz on Science: Biology', 'Biology Set I', '2', '2', '&lt;p&gt;&lt;span style=&quot;color: rgb(88, 88, 88); font-family: Roboto, Verdana, Geneva, sans-serif; font-size: 16px;&quot;&gt;Biology is the science of life that also deals with the physicochemical aspects of life. For the convenience of the study, it is divided into several branches including botany, zoology, morphology, etc. Let us solve an interesting quiz based on life science that will help in the preparation of competitive examinations and enhance knowledge.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '2021-10-01 13:26:47', '2021-10-01 13:26:47', 0),
(6, 'Quiz : Atoms Definition', '01', '7', '3', '&lt;ul style=&quot;font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;&lt;li style=&quot;margin: 0px;&quot;&gt;&lt;font color=&quot;#ff0000&quot;&gt;&lt;b style=&quot;&quot;&gt;Warning&lt;/b&gt;: &lt;/font&gt;&lt;font color=&quot;#000000&quot;&gt;All questions carry 0 mark, please think carefully&lt;/font&gt;&lt;/li&gt;&lt;/ul&gt;', '2021-10-06 13:05:21', '2021-10-06 13:05:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `reasonId` int(11) NOT NULL,
  `reason` varchar(500) CHARACTER SET utf8 NOT NULL,
  `status` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`reasonId`, `reason`, `status`, `created`, `updated`) VALUES
(2, 'Reason 1', 1, '2022-10-28 12:39:54', '2022-10-28 11:13:57'),
(3, 'Reason 2', 1, '2022-10-28 13:06:31', '2022-10-28 11:06:31'),
(4, 'Reason 3', 1, '2022-10-28 13:06:40', '2022-10-28 11:06:40'),
(5, 'Reason 4', 1, '2022-10-28 13:06:48', '2022-10-29 06:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_calendar`
--

CREATE TABLE `schedule_calendar` (
  `sid` bigint(100) NOT NULL,
  `slotId` varchar(100) DEFAULT NULL,
  `instructorId` bigint(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `status` enum('1','2','3') DEFAULT '1' COMMENT '1=>''available'',2=>''booked'',''3''=>''completed''\r\n',
  `studentId` bigint(20) DEFAULT NULL,
  `bookingId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `session_conference_tbl`
--

CREATE TABLE `session_conference_tbl` (
  `conferenceId` bigint(20) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` int(11) NOT NULL,
  `meeting_url` varchar(255) NOT NULL,
  `passcode` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=''active'',0=''inactive''',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settingId` bigint(20) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `favicon` varchar(500) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `company` varchar(200) CHARACTER SET utf8 NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `facebook` tinytext,
  `twitter` tinytext,
  `linkedin` tinytext,
  `instagram` tinytext,
  `member_subscription` int(2) NOT NULL,
  `member_activity` int(2) NOT NULL,
  `weekly_report` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settingId`, `logo`, `favicon`, `title`, `company`, `address`, `email`, `phone`, `facebook`, `twitter`, `linkedin`, `instagram`, `member_subscription`, `member_activity`, `weekly_report`) VALUES
(1, 'dark-logo3.png', 'favicon.png', 'E-Learning Online ', 'E-Learning', 'Industrial Area, Durgapur, West Bengal 713208', 'info@elearning.com', '+1 123 456 7892', 'https://www.facebook.com/', 'https://twitter.com/', 'javascript:void(0);', 'https://www.instagram.com/', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_booked_classes`
--

CREATE TABLE `student_booked_classes` (
  `classId` bigint(20) NOT NULL,
  `bookingId` varchar(255) NOT NULL,
  `studentId` bigint(20) NOT NULL,
  `courseId` bigint(20) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` bigint(20) NOT NULL,
  `classDate` date NOT NULL,
  `fromTime` time DEFAULT NULL,
  `timezone` varchar(255) NOT NULL,
  `toTime` time DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_booked_classes_history`
--

CREATE TABLE `student_booked_classes_history` (
  `classId` bigint(20) NOT NULL,
  `requestType` enum('1','2','3') NOT NULL COMMENT '1=>Change instructor\r\n2=> Cancel student'',\r\n3=> Cancel course''',
  `requestId` int(11) NOT NULL,
  `bookingId` varchar(255) NOT NULL,
  `studentId` bigint(20) NOT NULL,
  `courseId` bigint(20) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `instructorId` bigint(20) NOT NULL,
  `classDate` date NOT NULL,
  `fromTime` time DEFAULT NULL,
  `toTime` time DEFAULT NULL,
  `timezone` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_cancelled_courses`
--

CREATE TABLE `student_cancelled_courses` (
  `purchaseId` bigint(20) NOT NULL,
  `requestType` enum('1','2') NOT NULL COMMENT '1=> Cancel student'', 2=> Cancel course'' 	',
  `requestId` int(11) NOT NULL,
  `uniquePurchaseId` varchar(255) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `courseId` bigint(20) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `lvlCost` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_data` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_course_whishlist`
--

CREATE TABLE `student_course_whishlist` (
  `wishId` int(11) NOT NULL,
  `userId` mediumint(9) NOT NULL,
  `courseId` mediumint(9) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course_whishlist`
--

INSERT INTO `student_course_whishlist` (`wishId`, `userId`, `courseId`, `courseLvl`, `updated`) VALUES
(2, 11, 11, 'beginner', '2023-04-04 17:02:05'),
(3, 11, 11, 'intermediate', '2023-04-04 17:02:20'),
(4, 11, 11, 'advanced', '2023-04-04 17:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `student_purchased_courses`
--

CREATE TABLE `student_purchased_courses` (
  `purchaseId` bigint(20) NOT NULL,
  `uniquePurchaseId` varchar(255) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `courseId` bigint(20) NOT NULL,
  `courseLvl` enum('beginner','intermediate','advanced') NOT NULL,
  `lvlCost` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `transaction_data` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_purchased_courses`
--

INSERT INTO `student_purchased_courses` (`purchaseId`, `uniquePurchaseId`, `userId`, `courseId`, `courseLvl`, `lvlCost`, `payment_method`, `payment_status`, `transaction_data`, `created`, `updated`) VALUES
(94, 'RUxDUFVJZDE=', 4, 19, 'beginner', 1000.00, 'Unknown', 'pending', 'a:2:{s:14:\"payment_method\";s:7:\"unknown\";s:6:\"amount\";s:7:\"1000.00\";}', '2023-04-13 15:20:44', '2023-04-21 17:21:00'),
(95, 'RUxDUFVJZDI=', 20, 19, 'beginner', 1000.00, 'Unknown', 'pending', 'a:2:{s:14:\"payment_method\";s:7:\"unknown\";s:6:\"amount\";s:7:\"1000.00\";}', '2023-05-15 06:08:33', '2023-05-15 11:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectId` bigint(20) NOT NULL,
  `subjectName` varchar(255) DEFAULT NULL,
  `summary` text,
  `objectives` text,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_by` enum('admin','instructor') NOT NULL DEFAULT 'admin',
  `creator_id` int(11) NOT NULL,
  `approve_status` enum('approved','forbidden') NOT NULL DEFAULT 'forbidden',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectId`, `subjectName`, `summary`, `objectives`, `image`, `status`, `created_by`, `creator_id`, `approve_status`, `created`, `updated`) VALUES
(14, 'Development', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '63c00fd9c27ef.jpg', 1, 'admin', 1, 'approved', '2023-01-12 13:49:13', '2023-01-12 13:57:44'),
(15, 'Search &amp; SMO', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;&quot;&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&lt;/span&gt;&lt;/p&gt;', '63c00ff78f494.jpg', 1, 'admin', 1, 'approved', '2023-01-12 13:49:43', '2023-01-12 13:57:38'),
(16, 'Art &amp; Design Courses', '&lt;p&gt;n this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;', '&lt;p&gt;n this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;', '63c01495e0959.jpg', 1, 'instructor', 6, 'approved', '2023-01-12 14:09:25', '2023-01-12 14:18:48'),
(17, 'Work of shadows', '&lt;p&gt;In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;', '&lt;p&gt;In this course, I take you from the fundamentals and concepts of data modeling all the way through a number of best practices and techniques that you&amp;rsquo;ll need to build data models in your organization. You&amp;rsquo;ll find many examples that clearly demonstrate the key concepts and techniques covered throughout the course.&lt;/p&gt;', '63c014d63159c.jpg', 1, 'instructor', 6, 'approved', '2023-01-12 14:10:30', '2023-01-12 14:18:46'),
(18, 'Programming', '&lt;p&gt;Programming&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;Learn programming&lt;/p&gt;', '63c6e6f5b34d1.jpg', 1, 'admin', 1, 'approved', '2023-01-17 18:20:37', '2023-01-17 18:20:37'),
(19, 'Solar', '&lt;p&gt;Test description&lt;/p&gt;', '&lt;p&gt;Test description&lt;/p&gt;', '63d0d4a846bc7.jpg', 1, 'instructor', 13, 'approved', '2023-01-25 07:05:12', '2023-01-25 07:07:22'),
(20, 'Electrical', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test&lt;/p&gt;', '63d0d59e3b798.png', 1, 'instructor', 13, 'approved', '2023-01-25 07:09:18', '2023-01-25 07:10:42'),
(21, 'Electrical (Advanced)', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test&lt;/p&gt;', '63d0d84fb0683.png', 1, 'instructor', 13, 'approved', '2023-01-25 07:20:47', '2023-01-25 07:21:43'),
(22, 'test course 1', '&lt;p&gt;this course is created to check whether an instructor can upload a course or not.&lt;/p&gt;', '&lt;p&gt;this course is created to check whether an instructor can upload a course or not.&lt;/p&gt;', '6433bba88d8fc.jpeg', 1, 'instructor', 6, 'forbidden', '2023-04-10 07:32:56', '2023-04-10 07:32:56'),
(23, 'english', '&lt;p&gt;test course 2&lt;/p&gt;', '&lt;p&gt;&lt;iframe src=&quot;https://www.youtube.com/embed/cJprHJ4mrPI&quot; width=&quot;560&quot; height=&quot;314&quot; allowfullscreen=&quot;allowfullscreen&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;', '6434fd7018b2e.jpeg', 1, 'instructor', 6, 'forbidden', '2023-04-11 06:25:52', '2023-04-11 06:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `testId` int(11) NOT NULL,
  `testNumber` varchar(255) DEFAULT NULL,
  `testName` varchar(255) DEFAULT NULL,
  `subjectId` int(11) NOT NULL COMMENT 'PK of tests',
  `chapterId` varchar(255) DEFAULT NULL COMMENT 'PK of Chapters',
  `lessonId` varchar(255) DEFAULT NULL COMMENT 'PK of tests',
  `instructions` text,
  `duration` varchar(255) DEFAULT NULL,
  `coverImg` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0-Inactive 1-Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`testId`, `testNumber`, `testName`, `subjectId`, `chapterId`, `lessonId`, `instructions`, `duration`, `coverImg`, `created`, `updated`, `status`) VALUES
(1, 'Diodes Jun 21', 'Diodes', 1, '1', '1', '&lt;p&gt;General Instructions:\r\n&lt;/p&gt;&lt;p&gt;(i) The question paper comprises four sections A, B, C and D. There are 36 questions in\r\nthe question paper. All questions are compulsory.\r\n&lt;/p&gt;&lt;p&gt;(ii) Section–A - question no. 1 to 20 - all questions and parts thereof are of one mark each.\r\nThese questions contain multiple choice questions (MCQs), very short answer\r\nquestions and assertion - reason type questions. Answers to these should be given in\r\none word or one sentence.\r\n&lt;/p&gt;&lt;p&gt;(iii) Section–B - question no. 21 to 26 are short answer type questions, carrying 2 marks\r\neach. Answers to these questions should in the range of 30 to 50 words.\r\n&lt;/p&gt;&lt;p&gt;(iv) Section–C - question no. 27 to 33 are short answer type questions, carrying 3 marks\r\neach. Answers to these questions should in the range of 50 to 80 words.\r\n&lt;/p&gt;&lt;p&gt;(v) Section–D – question no. - 34 to 36 are long answer type questions carrying 5 marks\r\neach. Answer to these questions should be in the range of 80 to 120 words.\r\n&lt;/p&gt;&lt;p&gt;(vi) There is no overall choice. However, internal choices have been provided in some\r\nquestions. A student has to attempt only one of the alternatives in such questions.\r\n&lt;/p&gt;&lt;p&gt;(vii) Wherever necessary, neat and properly labeled diagrams should be drawn.&lt;br&gt;&lt;/p&gt;', '3 Hours', '741.jpg', '2021-09-17 10:24:16', '2022-01-10 05:36:24', 0),
(2, 'Section 1', 'Water, pH and Macromolecules', 2, '2', '2', '&lt;p&gt;AbstractCyclic polymers possess different properties compared to their linear analogues of the same molecular weight, such as smaller hydrodynamic volumes and higher glass transition temperatures (Tg). &lt;/p&gt;&lt;p&gt;Cyclic poly(4-ethynylanisole) (cPEA) was synthesized via a catalytic ring-expansion of 4-ethynylanisole. The catalyst employed was a tungsten complex supported by a tetraanionic pincer ligand. Evidence of the cyclic topology comes from gel permeation chromatography, dynamic light scattering, static light scattering, and solution viscometry. &lt;/p&gt;&lt;p&gt;Demethylation of&amp;nbsp;cPEA&amp;nbsp;with boron tribromide affords cyclic poly(4-ethynylphenol) (cPEP-OH).&amp;nbsp;cPEP-OH&amp;nbsp;exhibits pH-responsive water solubility, being soluble in aqueous solutions at elevated pH and becoming insoluble under acidic conditions. The linear equivalent of&amp;nbsp;cPEP-OH&amp;nbsp;was also synthesized, and it exhibits similar pH responsiveness.&lt;/p&gt;', '30 Minutes', 'ch3.jpg', '2021-09-17 12:07:21', '2021-10-06 13:30:42', 1),
(4, 'Jun12', 'Test1', 3, '7', '3', '&lt;p&gt;june test&amp;nbsp;&lt;/p&gt;', '45 mins', '5c2715a8aedf4.jpg', '2021-10-06 13:15:28', '2021-10-06 13:15:28', 1);
INSERT INTO `tests` (`testId`, `testNumber`, `testName`, `subjectId`, `chapterId`, `lessonId`, `instructions`, `duration`, `coverImg`, `created`, `updated`, `status`) VALUES
(5, 'Test Number', 'Test Record', 1, '', '', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Maecenas ultricies mi ac eleifend consectetur. Donec aliquam lacinia quam, in egestas risus luctus id. Nam lectus nisi, accumsan ut sem ut, maximus consectetur quam. Praesent sed dui metus. Nunc tincidunt sollicitudin leo. Aenean luctus, nisi et ultricies auctor, ante ex commodo libero, nec egestas quam elit ullamcorper odio. Pellentesque consequat turpis vel rhoncus rhoncus. Quisque quis eleifend augue. Mauris non risus ligula.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;data:image/jpeg;base64,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', '15', 'pexels-karolina-grabowska-4386442.jpg', '2021-10-24 12:11:20', '2021-10-24 12:11:20', 1);
INSERT INTO `tests` (`testId`, `testNumber`, `testName`, `subjectId`, `chapterId`, `lessonId`, `instructions`, `duration`, `coverImg`, `created`, `updated`, `status`) VALUES
(6, '12', 'sdfdkjhdskjfh', 1, '', '', '&lt;p&gt;qwdehiedoifioedsfdsihfdsk&lt;br&gt;&lt;/p&gt;', 'dldfhlkdsfhdslhdslfddsssssssssddddddddddddddddddddddddddddddddd', 'images.png', '2021-11-27 12:56:30', '2021-11-27 12:56:30', 1),
(8, 'Section 1', 'Water, pH and Macromolecules', 2, '2', '2', '&lt;p&gt;AbstractCyclic polymers possess different properties compared to their linear analogues of the same molecular weight, such as smaller hydrodynamic volumes and higher glass transition temperatures (Tg). &lt;/p&gt;&lt;p&gt;Cyclic poly(4-ethynylanisole) (cPEA) was synthesized via a catalytic ring-expansion of 4-ethynylanisole. The catalyst employed was a tungsten complex supported by a tetraanionic pincer ligand. Evidence of the cyclic topology comes from gel permeation chromatography, dynamic light scattering, static light scattering, and solution viscometry. &lt;/p&gt;&lt;p&gt;Demethylation of&amp;nbsp;cPEA&amp;nbsp;with boron tribromide affords cyclic poly(4-ethynylphenol) (cPEP-OH).&amp;nbsp;cPEP-OH&amp;nbsp;exhibits pH-responsive water solubility, being soluble in aqueous solutions at elevated pH and becoming insoluble under acidic conditions. The linear equivalent of&amp;nbsp;cPEP-OH&amp;nbsp;was also synthesized, and it exhibits similar pH responsiveness.&lt;/p&gt;', '30 Minutes', '', '2021-12-02 06:11:54', '2021-12-02 06:11:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `timezone`
--

CREATE TABLE `timezone` (
  `country_code` char(3) NOT NULL,
  `timezone` varchar(125) NOT NULL DEFAULT '',
  `gmt_offset` float(10,2) DEFAULT NULL,
  `dst_offset` float(10,2) DEFAULT NULL,
  `raw_offset` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timezone`
--

INSERT INTO `timezone` (`country_code`, `timezone`, `gmt_offset`, `dst_offset`, `raw_offset`) VALUES
('AD', 'Europe/Andorra', 1.00, 2.00, 1.00),
('AE', 'Asia/Dubai', 4.00, 4.00, 4.00),
('AF', 'Asia/Kabul', 4.50, 4.50, 4.50),
('AG', 'America/Antigua', -4.00, -4.00, -4.00),
('AI', 'America/Anguilla', -4.00, -4.00, -4.00),
('AL', 'Europe/Tirane', 1.00, 2.00, 1.00),
('AM', 'Asia/Yerevan', 4.00, 4.00, 4.00),
('AO', 'Africa/Luanda', 1.00, 1.00, 1.00),
('AQ', 'Antarctica/Casey', 8.00, 8.00, 8.00),
('AQ', 'Antarctica/Davis', 7.00, 7.00, 7.00),
('AQ', 'Antarctica/DumontDUrville', 10.00, 10.00, 10.00),
('AQ', 'Antarctica/Mawson', 5.00, 5.00, 5.00),
('AQ', 'Antarctica/McMurdo', 13.00, 12.00, 12.00),
('AQ', 'Antarctica/Palmer', -3.00, -4.00, -4.00),
('AQ', 'Antarctica/Rothera', -3.00, -3.00, -3.00),
('AQ', 'Antarctica/South_Pole', 13.00, 12.00, 12.00),
('AQ', 'Antarctica/Syowa', 3.00, 3.00, 3.00),
('AQ', 'Antarctica/Vostok', 6.00, 6.00, 6.00),
('AR', 'America/Argentina/Buenos_Aires', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Catamarca', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Cordoba', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Jujuy', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/La_Rioja', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Mendoza', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Rio_Gallegos', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Salta', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/San_Juan', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/San_Luis', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Tucuman', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Ushuaia', -3.00, -3.00, -3.00),
('AS', 'Pacific/Pago_Pago', -11.00, -11.00, -11.00),
('AT', 'Europe/Vienna', 1.00, 2.00, 1.00),
('AU', 'Antarctica/Macquarie', 11.00, 11.00, 11.00),
('AU', 'Australia/Adelaide', 10.50, 9.50, 9.50),
('AU', 'Australia/Brisbane', 10.00, 10.00, 10.00),
('AU', 'Australia/Broken_Hill', 10.50, 9.50, 9.50),
('AU', 'Australia/Currie', 11.00, 10.00, 10.00),
('AU', 'Australia/Darwin', 9.50, 9.50, 9.50),
('AU', 'Australia/Eucla', 8.75, 8.75, 8.75),
('AU', 'Australia/Hobart', 11.00, 10.00, 10.00),
('AU', 'Australia/Lindeman', 10.00, 10.00, 10.00),
('AU', 'Australia/Lord_Howe', 11.00, 10.50, 10.50),
('AU', 'Australia/Melbourne', 11.00, 10.00, 10.00),
('AU', 'Australia/Perth', 8.00, 8.00, 8.00),
('AU', 'Australia/Sydney', 11.00, 10.00, 10.00),
('AW', 'America/Aruba', -4.00, -4.00, -4.00),
('AX', 'Europe/Mariehamn', 2.00, 3.00, 2.00),
('AZ', 'Asia/Baku', 4.00, 5.00, 4.00),
('BA', 'Europe/Sarajevo', 1.00, 2.00, 1.00),
('BB', 'America/Barbados', -4.00, -4.00, -4.00),
('BD', 'Asia/Dhaka', 6.00, 6.00, 6.00),
('BE', 'Europe/Brussels', 1.00, 2.00, 1.00),
('BF', 'Africa/Ouagadougou', 0.00, 0.00, 0.00),
('BG', 'Europe/Sofia', 2.00, 3.00, 2.00),
('BH', 'Asia/Bahrain', 3.00, 3.00, 3.00),
('BI', 'Africa/Bujumbura', 2.00, 2.00, 2.00),
('BJ', 'Africa/Porto-Novo', 1.00, 1.00, 1.00),
('BL', 'America/St_Barthelemy', -4.00, -4.00, -4.00),
('BM', 'Atlantic/Bermuda', -4.00, -3.00, -4.00),
('BN', 'Asia/Brunei', 8.00, 8.00, 8.00),
('BO', 'America/La_Paz', -4.00, -4.00, -4.00),
('BQ', 'America/Kralendijk', -4.00, -4.00, -4.00),
('BR', 'America/Araguaina', -3.00, -3.00, -3.00),
('BR', 'America/Bahia', -3.00, -3.00, -3.00),
('BR', 'America/Belem', -3.00, -3.00, -3.00),
('BR', 'America/Boa_Vista', -4.00, -4.00, -4.00),
('BR', 'America/Campo_Grande', -3.00, -4.00, -4.00),
('BR', 'America/Cuiaba', -3.00, -4.00, -4.00),
('BR', 'America/Eirunepe', -5.00, -5.00, -5.00),
('BR', 'America/Fortaleza', -3.00, -3.00, -3.00),
('BR', 'America/Maceio', -3.00, -3.00, -3.00),
('BR', 'America/Manaus', -4.00, -4.00, -4.00),
('BR', 'America/Noronha', -2.00, -2.00, -2.00),
('BR', 'America/Porto_Velho', -4.00, -4.00, -4.00),
('BR', 'America/Recife', -3.00, -3.00, -3.00),
('BR', 'America/Rio_Branco', -5.00, -5.00, -5.00),
('BR', 'America/Santarem', -3.00, -3.00, -3.00),
('BR', 'America/Sao_Paulo', -2.00, -3.00, -3.00),
('BS', 'America/Nassau', -5.00, -4.00, -5.00),
('BT', 'Asia/Thimphu', 6.00, 6.00, 6.00),
('BW', 'Africa/Gaborone', 2.00, 2.00, 2.00),
('BY', 'Europe/Minsk', 3.00, 3.00, 3.00),
('BZ', 'America/Belize', -6.00, -6.00, -6.00),
('CA', 'America/Atikokan', -5.00, -5.00, -5.00),
('CA', 'America/Blanc-Sablon', -4.00, -4.00, -4.00),
('CA', 'America/Cambridge_Bay', -7.00, -6.00, -7.00),
('CA', 'America/Creston', -7.00, -7.00, -7.00),
('CA', 'America/Dawson', -8.00, -7.00, -8.00),
('CA', 'America/Dawson_Creek', -7.00, -7.00, -7.00),
('CA', 'America/Edmonton', -7.00, -6.00, -7.00),
('CA', 'America/Glace_Bay', -4.00, -3.00, -4.00),
('CA', 'America/Goose_Bay', -4.00, -3.00, -4.00),
('CA', 'America/Halifax', -4.00, -3.00, -4.00),
('CA', 'America/Inuvik', -7.00, -6.00, -7.00),
('CA', 'America/Iqaluit', -5.00, -4.00, -5.00),
('CA', 'America/Moncton', -4.00, -3.00, -4.00),
('CA', 'America/Montreal', -5.00, -4.00, -5.00),
('CA', 'America/Nipigon', -5.00, -4.00, -5.00),
('CA', 'America/Pangnirtung', -5.00, -4.00, -5.00),
('CA', 'America/Rainy_River', -6.00, -5.00, -6.00),
('CA', 'America/Rankin_Inlet', -6.00, -5.00, -6.00),
('CA', 'America/Regina', -6.00, -6.00, -6.00),
('CA', 'America/Resolute', -6.00, -5.00, -6.00),
('CA', 'America/St_Johns', -3.50, -2.50, -3.50),
('CA', 'America/Swift_Current', -6.00, -6.00, -6.00),
('CA', 'America/Thunder_Bay', -5.00, -4.00, -5.00),
('CA', 'America/Toronto', -5.00, -4.00, -5.00),
('CA', 'America/Vancouver', -8.00, -7.00, -8.00),
('CA', 'America/Whitehorse', -8.00, -7.00, -8.00),
('CA', 'America/Winnipeg', -6.00, -5.00, -6.00),
('CA', 'America/Yellowknife', -7.00, -6.00, -7.00),
('CC', 'Indian/Cocos', 6.50, 6.50, 6.50),
('CD', 'Africa/Kinshasa', 1.00, 1.00, 1.00),
('CD', 'Africa/Lubumbashi', 2.00, 2.00, 2.00),
('CF', 'Africa/Bangui', 1.00, 1.00, 1.00),
('CG', 'Africa/Brazzaville', 1.00, 1.00, 1.00),
('CH', 'Europe/Zurich', 1.00, 2.00, 1.00),
('CI', 'Africa/Abidjan', 0.00, 0.00, 0.00),
('CK', 'Pacific/Rarotonga', -10.00, -10.00, -10.00),
('CL', 'America/Santiago', -3.00, -4.00, -4.00),
('CL', 'Pacific/Easter', -5.00, -6.00, -6.00),
('CM', 'Africa/Douala', 1.00, 1.00, 1.00),
('CN', 'Asia/Chongqing', 8.00, 8.00, 8.00),
('CN', 'Asia/Harbin', 8.00, 8.00, 8.00),
('CN', 'Asia/Kashgar', 8.00, 8.00, 8.00),
('CN', 'Asia/Shanghai', 8.00, 8.00, 8.00),
('CN', 'Asia/Urumqi', 8.00, 8.00, 8.00),
('CO', 'America/Bogota', -5.00, -5.00, -5.00),
('CR', 'America/Costa_Rica', -6.00, -6.00, -6.00),
('CU', 'America/Havana', -5.00, -4.00, -5.00),
('CV', 'Atlantic/Cape_Verde', -1.00, -1.00, -1.00),
('CW', 'America/Curacao', -4.00, -4.00, -4.00),
('CX', 'Indian/Christmas', 7.00, 7.00, 7.00),
('CY', 'Asia/Nicosia', 2.00, 3.00, 2.00),
('CZ', 'Europe/Prague', 1.00, 2.00, 1.00),
('DE', 'Europe/Berlin', 1.00, 2.00, 1.00),
('DE', 'Europe/Busingen', 1.00, 2.00, 1.00),
('DJ', 'Africa/Djibouti', 3.00, 3.00, 3.00),
('DK', 'Europe/Copenhagen', 1.00, 2.00, 1.00),
('DM', 'America/Dominica', -4.00, -4.00, -4.00),
('DO', 'America/Santo_Domingo', -4.00, -4.00, -4.00),
('DZ', 'Africa/Algiers', 1.00, 1.00, 1.00),
('EC', 'America/Guayaquil', -5.00, -5.00, -5.00),
('EC', 'Pacific/Galapagos', -6.00, -6.00, -6.00),
('EE', 'Europe/Tallinn', 2.00, 3.00, 2.00),
('EG', 'Africa/Cairo', 2.00, 2.00, 2.00),
('EH', 'Africa/El_Aaiun', 0.00, 0.00, 0.00),
('ER', 'Africa/Asmara', 3.00, 3.00, 3.00),
('ES', 'Africa/Ceuta', 1.00, 2.00, 1.00),
('ES', 'Atlantic/Canary', 0.00, 1.00, 0.00),
('ES', 'Europe/Madrid', 1.00, 2.00, 1.00),
('ET', 'Africa/Addis_Ababa', 3.00, 3.00, 3.00),
('FI', 'Europe/Helsinki', 2.00, 3.00, 2.00),
('FJ', 'Pacific/Fiji', 13.00, 12.00, 12.00),
('FK', 'Atlantic/Stanley', -3.00, -3.00, -3.00),
('FM', 'Pacific/Chuuk', 10.00, 10.00, 10.00),
('FM', 'Pacific/Kosrae', 11.00, 11.00, 11.00),
('FM', 'Pacific/Pohnpei', 11.00, 11.00, 11.00),
('FO', 'Atlantic/Faroe', 0.00, 1.00, 0.00),
('FR', 'Europe/Paris', 1.00, 2.00, 1.00),
('GA', 'Africa/Libreville', 1.00, 1.00, 1.00),
('GB', 'Europe/London', 0.00, 1.00, 0.00),
('GD', 'America/Grenada', -4.00, -4.00, -4.00),
('GE', 'Asia/Tbilisi', 4.00, 4.00, 4.00),
('GF', 'America/Cayenne', -3.00, -3.00, -3.00),
('GG', 'Europe/Guernsey', 0.00, 1.00, 0.00),
('GH', 'Africa/Accra', 0.00, 0.00, 0.00),
('GI', 'Europe/Gibraltar', 1.00, 2.00, 1.00),
('GL', 'America/Danmarkshavn', 0.00, 0.00, 0.00),
('GL', 'America/Godthab', -3.00, -2.00, -3.00),
('GL', 'America/Scoresbysund', -1.00, 0.00, -1.00),
('GL', 'America/Thule', -4.00, -3.00, -4.00),
('GM', 'Africa/Banjul', 0.00, 0.00, 0.00),
('GN', 'Africa/Conakry', 0.00, 0.00, 0.00),
('GP', 'America/Guadeloupe', -4.00, -4.00, -4.00),
('GQ', 'Africa/Malabo', 1.00, 1.00, 1.00),
('GR', 'Europe/Athens', 2.00, 3.00, 2.00),
('GS', 'Atlantic/South_Georgia', -2.00, -2.00, -2.00),
('GT', 'America/Guatemala', -6.00, -6.00, -6.00),
('GU', 'Pacific/Guam', 10.00, 10.00, 10.00),
('GW', 'Africa/Bissau', 0.00, 0.00, 0.00),
('GY', 'America/Guyana', -4.00, -4.00, -4.00),
('HK', 'Asia/Hong_Kong', 8.00, 8.00, 8.00),
('HN', 'America/Tegucigalpa', -6.00, -6.00, -6.00),
('HR', 'Europe/Zagreb', 1.00, 2.00, 1.00),
('HT', 'America/Port-au-Prince', -5.00, -4.00, -5.00),
('HU', 'Europe/Budapest', 1.00, 2.00, 1.00),
('ID', 'Asia/Jakarta', 7.00, 7.00, 7.00),
('ID', 'Asia/Jayapura', 9.00, 9.00, 9.00),
('ID', 'Asia/Makassar', 8.00, 8.00, 8.00),
('ID', 'Asia/Pontianak', 7.00, 7.00, 7.00),
('IE', 'Europe/Dublin', 0.00, 1.00, 0.00),
('IL', 'Asia/Jerusalem', 2.00, 3.00, 2.00),
('IM', 'Europe/Isle_of_Man', 0.00, 1.00, 0.00),
('IN', 'Asia/Kolkata', 5.50, 5.50, 5.50),
('IO', 'Indian/Chagos', 6.00, 6.00, 6.00),
('IQ', 'Asia/Baghdad', 3.00, 3.00, 3.00),
('IR', 'Asia/Tehran', 3.50, 4.50, 3.50),
('IS', 'Atlantic/Reykjavik', 0.00, 0.00, 0.00),
('IT', 'Europe/Rome', 1.00, 2.00, 1.00),
('JE', 'Europe/Jersey', 0.00, 1.00, 0.00),
('JM', 'America/Jamaica', -5.00, -5.00, -5.00),
('JO', 'Asia/Amman', 2.00, 3.00, 2.00),
('JP', 'Asia/Tokyo', 9.00, 9.00, 9.00),
('KE', 'Africa/Nairobi', 3.00, 3.00, 3.00),
('KG', 'Asia/Bishkek', 6.00, 6.00, 6.00),
('KH', 'Asia/Phnom_Penh', 7.00, 7.00, 7.00),
('KI', 'Pacific/Enderbury', 13.00, 13.00, 13.00),
('KI', 'Pacific/Kiritimati', 14.00, 14.00, 14.00),
('KI', 'Pacific/Tarawa', 12.00, 12.00, 12.00),
('KM', 'Indian/Comoro', 3.00, 3.00, 3.00),
('KN', 'America/St_Kitts', -4.00, -4.00, -4.00),
('KP', 'Asia/Pyongyang', 9.00, 9.00, 9.00),
('KR', 'Asia/Seoul', 9.00, 9.00, 9.00),
('KW', 'Asia/Kuwait', 3.00, 3.00, 3.00),
('KY', 'America/Cayman', -5.00, -5.00, -5.00),
('KZ', 'Asia/Almaty', 6.00, 6.00, 6.00),
('KZ', 'Asia/Aqtau', 5.00, 5.00, 5.00),
('KZ', 'Asia/Aqtobe', 5.00, 5.00, 5.00),
('KZ', 'Asia/Oral', 5.00, 5.00, 5.00),
('KZ', 'Asia/Qyzylorda', 6.00, 6.00, 6.00),
('LA', 'Asia/Vientiane', 7.00, 7.00, 7.00),
('LB', 'Asia/Beirut', 2.00, 3.00, 2.00),
('LC', 'America/St_Lucia', -4.00, -4.00, -4.00),
('LI', 'Europe/Vaduz', 1.00, 2.00, 1.00),
('LK', 'Asia/Colombo', 5.50, 5.50, 5.50),
('LR', 'Africa/Monrovia', 0.00, 0.00, 0.00),
('LS', 'Africa/Maseru', 2.00, 2.00, 2.00),
('LT', 'Europe/Vilnius', 2.00, 3.00, 2.00),
('LU', 'Europe/Luxembourg', 1.00, 2.00, 1.00),
('LV', 'Europe/Riga', 2.00, 3.00, 2.00),
('LY', 'Africa/Tripoli', 2.00, 2.00, 2.00),
('MA', 'Africa/Casablanca', 0.00, 0.00, 0.00),
('MC', 'Europe/Monaco', 1.00, 2.00, 1.00),
('MD', 'Europe/Chisinau', 2.00, 3.00, 2.00),
('ME', 'Europe/Podgorica', 1.00, 2.00, 1.00),
('MF', 'America/Marigot', -4.00, -4.00, -4.00),
('MG', 'Indian/Antananarivo', 3.00, 3.00, 3.00),
('MH', 'Pacific/Kwajalein', 12.00, 12.00, 12.00),
('MH', 'Pacific/Majuro', 12.00, 12.00, 12.00),
('MK', 'Europe/Skopje', 1.00, 2.00, 1.00),
('ML', 'Africa/Bamako', 0.00, 0.00, 0.00),
('MM', 'Asia/Rangoon', 6.50, 6.50, 6.50),
('MN', 'Asia/Choibalsan', 8.00, 8.00, 8.00),
('MN', 'Asia/Hovd', 7.00, 7.00, 7.00),
('MN', 'Asia/Ulaanbaatar', 8.00, 8.00, 8.00),
('MO', 'Asia/Macau', 8.00, 8.00, 8.00),
('MP', 'Pacific/Saipan', 10.00, 10.00, 10.00),
('MQ', 'America/Martinique', -4.00, -4.00, -4.00),
('MR', 'Africa/Nouakchott', 0.00, 0.00, 0.00),
('MS', 'America/Montserrat', -4.00, -4.00, -4.00),
('MT', 'Europe/Malta', 1.00, 2.00, 1.00),
('MU', 'Indian/Mauritius', 4.00, 4.00, 4.00),
('MV', 'Indian/Maldives', 5.00, 5.00, 5.00),
('MW', 'Africa/Blantyre', 2.00, 2.00, 2.00),
('MX', 'America/Bahia_Banderas', -6.00, -5.00, -6.00),
('MX', 'America/Cancun', -6.00, -5.00, -6.00),
('MX', 'America/Chihuahua', -7.00, -6.00, -7.00),
('MX', 'America/Hermosillo', -7.00, -7.00, -7.00),
('MX', 'America/Matamoros', -6.00, -5.00, -6.00),
('MX', 'America/Mazatlan', -7.00, -6.00, -7.00),
('MX', 'America/Merida', -6.00, -5.00, -6.00),
('MX', 'America/Mexico_City', -6.00, -5.00, -6.00),
('MX', 'America/Monterrey', -6.00, -5.00, -6.00),
('MX', 'America/Ojinaga', -7.00, -6.00, -7.00),
('MX', 'America/Santa_Isabel', -8.00, -7.00, -8.00),
('MX', 'America/Tijuana', -8.00, -7.00, -8.00),
('MY', 'Asia/Kuala_Lumpur', 8.00, 8.00, 8.00),
('MY', 'Asia/Kuching', 8.00, 8.00, 8.00),
('MZ', 'Africa/Maputo', 2.00, 2.00, 2.00),
('NA', 'Africa/Windhoek', 2.00, 1.00, 1.00),
('NC', 'Pacific/Noumea', 11.00, 11.00, 11.00),
('NE', 'Africa/Niamey', 1.00, 1.00, 1.00),
('NF', 'Pacific/Norfolk', 11.50, 11.50, 11.50),
('NG', 'Africa/Lagos', 1.00, 1.00, 1.00),
('NI', 'America/Managua', -6.00, -6.00, -6.00),
('NL', 'Europe/Amsterdam', 1.00, 2.00, 1.00),
('NO', 'Europe/Oslo', 1.00, 2.00, 1.00),
('NP', 'Asia/Kathmandu', 5.75, 5.75, 5.75),
('NR', 'Pacific/Nauru', 12.00, 12.00, 12.00),
('NU', 'Pacific/Niue', -11.00, -11.00, -11.00),
('NZ', 'Pacific/Auckland', 13.00, 12.00, 12.00),
('NZ', 'Pacific/Chatham', 13.75, 12.75, 12.75),
('OM', 'Asia/Muscat', 4.00, 4.00, 4.00),
('PA', 'America/Panama', -5.00, -5.00, -5.00),
('PE', 'America/Lima', -5.00, -5.00, -5.00),
('PF', 'Pacific/Gambier', -9.00, -9.00, -9.00),
('PF', 'Pacific/Marquesas', -9.50, -9.50, -9.50),
('PF', 'Pacific/Tahiti', -10.00, -10.00, -10.00),
('PG', 'Pacific/Port_Moresby', 10.00, 10.00, 10.00),
('PH', 'Asia/Manila', 8.00, 8.00, 8.00),
('PK', 'Asia/Karachi', 5.00, 5.00, 5.00),
('PL', 'Europe/Warsaw', 1.00, 2.00, 1.00),
('PM', 'America/Miquelon', -3.00, -2.00, -3.00),
('PN', 'Pacific/Pitcairn', -8.00, -8.00, -8.00),
('PR', 'America/Puerto_Rico', -4.00, -4.00, -4.00),
('PS', 'Asia/Gaza', 2.00, 3.00, 2.00),
('PS', 'Asia/Hebron', 2.00, 3.00, 2.00),
('PT', 'Atlantic/Azores', -1.00, 0.00, -1.00),
('PT', 'Atlantic/Madeira', 0.00, 1.00, 0.00),
('PT', 'Europe/Lisbon', 0.00, 1.00, 0.00),
('PW', 'Pacific/Palau', 9.00, 9.00, 9.00),
('PY', 'America/Asuncion', -3.00, -4.00, -4.00),
('QA', 'Asia/Qatar', 3.00, 3.00, 3.00),
('RE', 'Indian/Reunion', 4.00, 4.00, 4.00),
('RO', 'Europe/Bucharest', 2.00, 3.00, 2.00),
('RS', 'Europe/Belgrade', 1.00, 2.00, 1.00),
('RU', 'Asia/Anadyr', 12.00, 12.00, 12.00),
('RU', 'Asia/Irkutsk', 9.00, 9.00, 9.00),
('RU', 'Asia/Kamchatka', 12.00, 12.00, 12.00),
('RU', 'Asia/Khandyga', 10.00, 10.00, 10.00),
('RU', 'Asia/Krasnoyarsk', 8.00, 8.00, 8.00),
('RU', 'Asia/Magadan', 12.00, 12.00, 12.00),
('RU', 'Asia/Novokuznetsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Novosibirsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Omsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Sakhalin', 11.00, 11.00, 11.00),
('RU', 'Asia/Ust-Nera', 11.00, 11.00, 11.00),
('RU', 'Asia/Vladivostok', 11.00, 11.00, 11.00),
('RU', 'Asia/Yakutsk', 10.00, 10.00, 10.00),
('RU', 'Asia/Yekaterinburg', 6.00, 6.00, 6.00),
('RU', 'Europe/Kaliningrad', 3.00, 3.00, 3.00),
('RU', 'Europe/Moscow', 4.00, 4.00, 4.00),
('RU', 'Europe/Samara', 4.00, 4.00, 4.00),
('RU', 'Europe/Volgograd', 4.00, 4.00, 4.00),
('RW', 'Africa/Kigali', 2.00, 2.00, 2.00),
('SA', 'Asia/Riyadh', 3.00, 3.00, 3.00),
('SB', 'Pacific/Guadalcanal', 11.00, 11.00, 11.00),
('SC', 'Indian/Mahe', 4.00, 4.00, 4.00),
('SD', 'Africa/Khartoum', 3.00, 3.00, 3.00),
('SE', 'Europe/Stockholm', 1.00, 2.00, 1.00),
('SG', 'Asia/Singapore', 8.00, 8.00, 8.00),
('SH', 'Atlantic/St_Helena', 0.00, 0.00, 0.00),
('SI', 'Europe/Ljubljana', 1.00, 2.00, 1.00),
('SJ', 'Arctic/Longyearbyen', 1.00, 2.00, 1.00),
('SK', 'Europe/Bratislava', 1.00, 2.00, 1.00),
('SL', 'Africa/Freetown', 0.00, 0.00, 0.00),
('SM', 'Europe/San_Marino', 1.00, 2.00, 1.00),
('SN', 'Africa/Dakar', 0.00, 0.00, 0.00),
('SO', 'Africa/Mogadishu', 3.00, 3.00, 3.00),
('SR', 'America/Paramaribo', -3.00, -3.00, -3.00),
('SS', 'Africa/Juba', 3.00, 3.00, 3.00),
('ST', 'Africa/Sao_Tome', 0.00, 0.00, 0.00),
('SV', 'America/El_Salvador', -6.00, -6.00, -6.00),
('SX', 'America/Lower_Princes', -4.00, -4.00, -4.00),
('SY', 'Asia/Damascus', 2.00, 3.00, 2.00),
('SZ', 'Africa/Mbabane', 2.00, 2.00, 2.00),
('TC', 'America/Grand_Turk', -5.00, -4.00, -5.00),
('TD', 'Africa/Ndjamena', 1.00, 1.00, 1.00),
('TF', 'Indian/Kerguelen', 5.00, 5.00, 5.00),
('TG', 'Africa/Lome', 0.00, 0.00, 0.00),
('TH', 'Asia/Bangkok', 7.00, 7.00, 7.00),
('TJ', 'Asia/Dushanbe', 5.00, 5.00, 5.00),
('TK', 'Pacific/Fakaofo', 13.00, 13.00, 13.00),
('TL', 'Asia/Dili', 9.00, 9.00, 9.00),
('TM', 'Asia/Ashgabat', 5.00, 5.00, 5.00),
('TN', 'Africa/Tunis', 1.00, 1.00, 1.00),
('TO', 'Pacific/Tongatapu', 13.00, 13.00, 13.00),
('TR', 'Europe/Istanbul', 2.00, 3.00, 2.00),
('TT', 'America/Port_of_Spain', -4.00, -4.00, -4.00),
('TV', 'Pacific/Funafuti', 12.00, 12.00, 12.00),
('TW', 'Asia/Taipei', 8.00, 8.00, 8.00),
('TZ', 'Africa/Dar_es_Salaam', 3.00, 3.00, 3.00),
('UA', 'Europe/Kiev', 2.00, 3.00, 2.00),
('UA', 'Europe/Simferopol', 2.00, 4.00, 4.00),
('UA', 'Europe/Uzhgorod', 2.00, 3.00, 2.00),
('UA', 'Europe/Zaporozhye', 2.00, 3.00, 2.00),
('UG', 'Africa/Kampala', 3.00, 3.00, 3.00),
('UM', 'Pacific/Johnston', -10.00, -10.00, -10.00),
('UM', 'Pacific/Midway', -11.00, -11.00, -11.00),
('UM', 'Pacific/Wake', 12.00, 12.00, 12.00),
('US', 'America/Adak', -10.00, -9.00, -10.00),
('US', 'America/Anchorage', -9.00, -8.00, -9.00),
('US', 'America/Boise', -7.00, -6.00, -7.00),
('US', 'America/Chicago', -6.00, -5.00, -6.00),
('US', 'America/Denver', -7.00, -6.00, -7.00),
('US', 'America/Detroit', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Indianapolis', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Knox', -6.00, -5.00, -6.00),
('US', 'America/Indiana/Marengo', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Petersburg', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Tell_City', -6.00, -5.00, -6.00),
('US', 'America/Indiana/Vevay', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Vincennes', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Winamac', -5.00, -4.00, -5.00),
('US', 'America/Juneau', -9.00, -8.00, -9.00),
('US', 'America/Kentucky/Louisville', -5.00, -4.00, -5.00),
('US', 'America/Kentucky/Monticello', -5.00, -4.00, -5.00),
('US', 'America/Los_Angeles', -8.00, -7.00, -8.00),
('US', 'America/Menominee', -6.00, -5.00, -6.00),
('US', 'America/Metlakatla', -8.00, -8.00, -8.00),
('US', 'America/New_York', -5.00, -4.00, -5.00),
('US', 'America/Nome', -9.00, -8.00, -9.00),
('US', 'America/North_Dakota/Beulah', -6.00, -5.00, -6.00),
('US', 'America/North_Dakota/Center', -6.00, -5.00, -6.00),
('US', 'America/North_Dakota/New_Salem', -6.00, -5.00, -6.00),
('US', 'America/Phoenix', -7.00, -7.00, -7.00),
('US', 'America/Shiprock', -7.00, -6.00, -7.00),
('US', 'America/Sitka', -9.00, -8.00, -9.00),
('US', 'America/Yakutat', -9.00, -8.00, -9.00),
('US', 'Pacific/Honolulu', -10.00, -10.00, -10.00),
('UY', 'America/Montevideo', -2.00, -3.00, -3.00),
('UZ', 'Asia/Samarkand', 5.00, 5.00, 5.00),
('UZ', 'Asia/Tashkent', 5.00, 5.00, 5.00),
('VA', 'Europe/Vatican', 1.00, 2.00, 1.00),
('VC', 'America/St_Vincent', -4.00, -4.00, -4.00),
('VE', 'America/Caracas', -4.50, -4.50, -4.50),
('VG', 'America/Tortola', -4.00, -4.00, -4.00),
('VI', 'America/St_Thomas', -4.00, -4.00, -4.00),
('VN', 'Asia/Ho_Chi_Minh', 7.00, 7.00, 7.00),
('VU', 'Pacific/Efate', 11.00, 11.00, 11.00),
('WF', 'Pacific/Wallis', 12.00, 12.00, 12.00),
('WS', 'Pacific/Apia', 14.00, 13.00, 13.00),
('YE', 'Asia/Aden', 3.00, 3.00, 3.00),
('YT', 'Indian/Mayotte', 3.00, 3.00, 3.00),
('ZA', 'Africa/Johannesburg', 2.00, 2.00, 2.00),
('ZM', 'Africa/Lusaka', 2.00, 2.00, 2.00),
('ZW', 'Africa/Harare', 2.00, 2.00, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `ccName` varchar(255) DEFAULT NULL,
  `ccCode` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) NOT NULL,
  `origin_country` varchar(255) NOT NULL,
  `mobile` varchar(200) DEFAULT NULL,
  `dob` varchar(255) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `profilePic` text,
  `intro_video` varchar(255) DEFAULT NULL,
  `cv` varchar(255) NOT NULL,
  `payment_info` longtext,
  `userType` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '1=Student, 2=Teacher',
  `otp` int(11) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `descriptions` text,
  `verificationStatus` smallint(6) DEFAULT '0',
  `link` varchar(1000) DEFAULT NULL,
  `address` tinytext,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `status` enum('1','0') DEFAULT '1',
  `approve_status` enum('1','0') DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `email`, `ccName`, `ccCode`, `timezone`, `origin_country`, `mobile`, `dob`, `qualification`, `occupation`, `password`, `profilePic`, `intro_video`, `cv`, `payment_info`, `userType`, `otp`, `auth_token`, `descriptions`, `verificationStatus`, `link`, `address`, `latitude`, `longitude`, `status`, `approve_status`, `created`, `modified`) VALUES
(4, 'Asmit', 'Banerjee', 'igi223@goigi.in', 'us', '1', 'Asia/Kolkata', '', '08617304367', '', NULL, NULL, '$2y$10$h33RqmNbK49PqC6WzpC39ueEfR9ZaFrXOgXdK92JhvUwb3cDhyRum', '63c001c76461f.jpg', '', '', NULL, 1, 0, '6404a1a8930d3168a648d25fcd4e08f7', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 0, NULL, NULL, NULL, NULL, '1', '0', '2023-04-13 09:52:18', '2023-04-13 15:22:18'),
(6, 'Neel', 'Banerjee', 'instructor@gmail.com', 'us', '1', 'Europe/London', 'UK', '086173043679', '', NULL, NULL, '$2y$10$Ad2EXhs3ihtoCFjnlzg07eKk35WqfwlUu46da/TAuzd63/6vKg8Ru', '63c00debbb993.jpg', 'https://youtu.be/LXb3EKWsInQ', '63c0051e78779.docx', 'a:6:{s:9:\"bank_name\";s:11:\"PMF BANCORP\";s:12:\"bank_address\";s:10:\"N S B Road\";s:13:\"ins_bank_name\";s:13:\"Asit Banerjee\";s:13:\"bank_acunt_no\";s:17:\"23461679258523456\";s:10:\"routing_no\";s:9:\"122105155\";s:10:\"swift_code\";s:11:\"PMFAUS66HKG\";}', 2, 0, '', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 0, NULL, NULL, NULL, NULL, '1', '1', '2023-01-12 07:33:26', '2023-04-24 11:09:47'),
(7, 'Harry', 'Cole', 'coleharry.live@gmail.com', '', '', '', '', '086173043679', '', NULL, NULL, '$2y$10$crS3d50Bsxy5PUSfLt2cOOtRNpQ.pvtadihs5VNHUZkzE8RBl0zHC', '', '', '63c0051e78779.docx', 'a:6:{s:9:\"bank_name\";s:11:\"PMF BANCORP\";s:12:\"bank_address\";s:10:\"N S B Road\";s:13:\"ins_bank_name\";s:13:\"Asit Banerjee\";s:13:\"bank_acunt_no\";s:17:\"23461679258523456\";s:10:\"routing_no\";s:9:\"122105155\";s:10:\"swift_code\";s:11:\"PMFAUS66HKG\";}', 2, 0, '', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 0, NULL, NULL, NULL, NULL, '1', '1', '2023-01-12 07:33:26', '2023-01-25 07:09:21'),
(8, 'MacKenzie', 'Gordon', 'ab@nator.com', '', '', '', '', '086173043679', '', NULL, NULL, '$2y$10$crS3d50Bsxy5PUSfLt2cOOtRNpQ.pvtadihs5VNHUZkzE8RBl0zHC', '', '', '63c0051e78779.docx', 'a:6:{s:9:\"bank_name\";s:11:\"PMF BANCORP\";s:12:\"bank_address\";s:10:\"N S B Road\";s:13:\"ins_bank_name\";s:13:\"Asit Banerjee\";s:13:\"bank_acunt_no\";s:17:\"23461679258523456\";s:10:\"routing_no\";s:9:\"122105155\";s:10:\"swift_code\";s:11:\"PMFAUS66HKG\";}', 2, 0, '', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 0, NULL, NULL, NULL, NULL, '1', '1', '2023-01-12 07:33:26', '2023-01-25 07:09:25'),
(9, 'Tom', 'Sanders', 'instructor@domain.com', '', '', '', '', '086173043679', '', NULL, NULL, '$2y$10$crS3d50Bsxy5PUSfLt2cOOtRNpQ.pvtadihs5VNHUZkzE8RBl0zHC', '', '', '', 'a:6:{s:9:\"bank_name\";s:11:\"PMF BANCORP\";s:12:\"bank_address\";s:10:\"N S B Road\";s:13:\"ins_bank_name\";s:13:\"Asit Banerjee\";s:13:\"bank_acunt_no\";s:17:\"23461679258523456\";s:10:\"routing_no\";s:9:\"122105155\";s:10:\"swift_code\";s:11:\"PMFAUS66HKG\";}', 2, 0, '', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 0, NULL, NULL, NULL, NULL, '1', '0', '2023-01-12 07:33:26', '2023-01-12 13:41:13'),
(10, 'Issam', 'Ogbah', 'issam.ogbah.dev@gmail.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$vGDTfdJS7UqUsp8/9wSpKejHVY76TLTEKCMVLkDa4kBFT1JuTTU1K', NULL, '', '', NULL, 1, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-01-16 13:51:01', '2023-01-25 06:33:04'),
(11, 'Issam', 'Ogbah', 'issam.ogbah.dev2@gmail.com', '', '', '', '', '+967 772241110', '', NULL, NULL, '$2y$10$54g8mm93HSxBezfuCDMVmeDmdAv9m8ZHqMJsYfJ3f9/YghtH3p6eO', '63c6e098db95e.png', '', '63c6e098dc307.docx', 'a:6:{s:9:\"bank_name\";s:3:\"YKB\";s:12:\"bank_address\";s:5:\"Sanaa\";s:13:\"ins_bank_name\";s:2:\"??\";s:13:\"bank_acunt_no\";s:3:\"111\";s:10:\"routing_no\";s:3:\"111\";s:10:\"swift_code\";s:3:\"222\";}', 2, 0, '', 'I\'m testing', 0, NULL, NULL, NULL, NULL, '1', '1', '2023-01-17 12:23:28', '2023-01-25 07:09:30'),
(12, 'Issam', 'Ogbah', 'issam.ogbah.dev3@gmail.com', 'ye', '967', '', '', '772241110', '', NULL, NULL, '$2y$10$PIEJYU768sYF1m/IIp.E9u9YnJ/ow7b.oRDXyGtv4.UM/XLYsSQpm', '63c5aac437a75.png', '', '', NULL, 1, 0, '', '', 0, NULL, NULL, NULL, NULL, '1', '0', '2023-01-16 14:21:32', '2023-01-16 19:52:35'),
(13, 'Prithwiraj', 'Bhattacharjee', 'care@goigi.com', '', '', '', '', '3475353666', '', NULL, NULL, '$2y$10$e4rphJk/3GN.pNQabhSBne4EpJcNXqD.2PIFf1pZ5/bIudaAzcC9C', '63d0d1b0d8536.jpg', '', '63d0d1b0d90a2.docx', 'a:6:{s:9:\"bank_name\";s:4:\"Test\";s:12:\"bank_address\";s:4:\"Test\";s:13:\"ins_bank_name\";s:4:\"Test\";s:13:\"bank_acunt_no\";s:9:\"123456789\";s:10:\"routing_no\";s:3:\"123\";s:10:\"swift_code\";s:5:\"12546\";}', 2, 0, '', 'Test Details', 0, NULL, NULL, NULL, NULL, '1', '1', '2023-01-25 01:22:32', '2023-01-25 07:30:58'),
(14, 'Student', 'One', 'a@b.com', 'us', '1', '', '', '1234567890', '', NULL, NULL, '$2y$10$.vW81M4NQ4vUHQos0ske/umJKAJgzVT/mWPdOuIQFWofSEyMZKWLm', '63d0ddbd8b250.jpg', '', '', NULL, 1, 0, '', 'test', 0, NULL, NULL, NULL, NULL, '1', '0', '2023-01-25 02:13:57', '2023-01-25 07:43:57'),
(15, 'Yusra', 'Ali', 'yusra.ali.zawia82@hotmail.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$M9lanpqLS5Tkpl/XwJRlIuqJj3N25B9srFmYk2dHVAFLGAyYpVCJe', NULL, NULL, '', NULL, 1, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-02-20 04:55:02', '2023-02-20 10:25:02'),
(16, 'Ali', 'Ali', 'yusra.ali.zawia82@gmail.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$pXYR6VyQHrh5btrGgLGT3ePKIQakNHQlVceZQXKn7zjBaoE7adfJS', NULL, NULL, '', NULL, 2, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-02-21 04:15:04', '2023-02-21 09:45:04'),
(17, 'Prithwiraj', 'Bhattacharjee', 'helpdesk@goigi.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$dGlf3fWy0CbuHHTTpa.QCuWJ7gus6a.lHDEfS6wSe.d6FyWv5MAWe', NULL, NULL, '', NULL, 1, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-03-30 02:24:03', '2023-03-30 07:54:03'),
(18, 'test', 'one', 'student@gmail.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$4M/xoehg2Cd9JCEh2SKXOetsjkEGLlJL2mvytpuInOTXmgIougDiW', NULL, NULL, '', NULL, 1, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-04-07 01:48:48', '2023-04-07 07:18:48'),
(19, 'bikas', 'kumar', 'bikas@gmail.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$IL0aqiGAG9fwIjgRZjBYwO8qb57NVajjw5Otr4bjnTfgGuEQ/ObNC', NULL, NULL, '', NULL, 2, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-05-15 00:30:30', '2023-05-15 06:00:30'),
(20, 'bikas', 'kumar', 'demo@gmail.com', NULL, NULL, '', '', NULL, '', NULL, NULL, '$2y$10$Wj8A6odVmRrIhGAvxy0B6.lTGCnPuMoGVnkq101BqkEbpw.49So9a', NULL, NULL, '', NULL, 1, 0, '', NULL, 0, NULL, NULL, NULL, NULL, '1', '0', '2023-05-15 00:35:30', '2023-05-15 06:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `users_temp_tbl`
--

CREATE TABLE `users_temp_tbl` (
  `userRowId` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `ccName` varchar(255) DEFAULT NULL,
  `ccCode` varchar(255) DEFAULT NULL,
  `mobile` varchar(200) DEFAULT NULL,
  `timezone` varchar(255) NOT NULL,
  `origin_country` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `profilePic` text,
  `intro_video` varchar(255) DEFAULT NULL,
  `cv` varchar(255) NOT NULL,
  `payment_info` longtext NOT NULL,
  `userType` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '1=Student, 2=Teacher',
  `descriptions` text,
  `address` tinytext,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_subject_enroll`
--

CREATE TABLE `user_subject_enroll` (
  `enrolId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL COMMENT 'PK of users',
  `subjectId` bigint(20) NOT NULL COMMENT 'PK of subjects',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_subject_saved`
--

CREATE TABLE `user_subject_saved` (
  `sId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL COMMENT 'PK of users',
  `subjectId` bigint(20) NOT NULL COMMENT 'PK of subjects',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_test_ans`
--

CREATE TABLE `user_test_ans` (
  `aid` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL COMMENT 'PK of users',
  `testId` int(11) DEFAULT NULL,
  `totalMarks` int(11) DEFAULT NULL,
  `scoredMarks` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '0-Inactive 1-Active',
  `resultDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_test_result`
--

CREATE TABLE `user_test_result` (
  `id` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  `attempId` int(11) NOT NULL COMMENT 'PK of user_test_ans'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`badgeId`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`articleId`);

--
-- Indexes for table `cancel_courses`
--
ALTER TABLE `cancel_courses`
  ADD PRIMARY KEY (`requestId`);

--
-- Indexes for table `cancel_courses_history`
--
ALTER TABLE `cancel_courses_history`
  ADD PRIMARY KEY (`requestId`);

--
-- Indexes for table `cancel_students`
--
ALTER TABLE `cancel_students`
  ADD PRIMARY KEY (`stuCourseId`);

--
-- Indexes for table `cancel_students_history`
--
ALTER TABLE `cancel_students_history`
  ADD PRIMARY KEY (`stuCourseId`);

--
-- Indexes for table `change_instructor`
--
ALTER TABLE `change_instructor`
  ADD PRIMARY KEY (`queryId`);

--
-- Indexes for table `change_instructor_history`
--
ALTER TABLE `change_instructor_history`
  ADD PRIMARY KEY (`queryId`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`chapterId`);

--
-- Indexes for table `chapter_carriculum_media`
--
ALTER TABLE `chapter_carriculum_media`
  ADD PRIMARY KEY (`mediaId`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`pageId`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `courses_chapters_bak`
--
ALTER TABLE `courses_chapters_bak`
  ADD PRIMARY KEY (`couChaId`);

--
-- Indexes for table `course_chapters`
--
ALTER TABLE `course_chapters`
  ADD PRIMARY KEY (`courseDetailId`);

--
-- Indexes for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD PRIMARY KEY (`courseInsId`);

--
-- Indexes for table `course_level_details`
--
ALTER TABLE `course_level_details`
  ADD PRIMARY KEY (`crsLvlId`);

--
-- Indexes for table `course_review`
--
ALTER TABLE `course_review`
  ADD PRIMARY KEY (`reviewId`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor_schedule_time`
--
ALTER TABLE `instructor_schedule_time`
  ADD PRIMARY KEY (`scheduleTimeId`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lessonId`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`packageId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`quesId`);

--
-- Indexes for table `questions_options`
--
ALTER TABLE `questions_options`
  ADD PRIMARY KEY (`optionId`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quizId`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
  ADD PRIMARY KEY (`reasonId`);

--
-- Indexes for table `schedule_calendar`
--
ALTER TABLE `schedule_calendar`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `session_conference_tbl`
--
ALTER TABLE `session_conference_tbl`
  ADD PRIMARY KEY (`conferenceId`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settingId`);

--
-- Indexes for table `student_booked_classes`
--
ALTER TABLE `student_booked_classes`
  ADD PRIMARY KEY (`classId`);

--
-- Indexes for table `student_booked_classes_history`
--
ALTER TABLE `student_booked_classes_history`
  ADD PRIMARY KEY (`classId`);

--
-- Indexes for table `student_cancelled_courses`
--
ALTER TABLE `student_cancelled_courses`
  ADD PRIMARY KEY (`purchaseId`);

--
-- Indexes for table `student_course_whishlist`
--
ALTER TABLE `student_course_whishlist`
  ADD PRIMARY KEY (`wishId`);

--
-- Indexes for table `student_purchased_courses`
--
ALTER TABLE `student_purchased_courses`
  ADD PRIMARY KEY (`purchaseId`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectId`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`testId`);

--
-- Indexes for table `timezone`
--
ALTER TABLE `timezone`
  ADD PRIMARY KEY (`country_code`,`timezone`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `users_temp_tbl`
--
ALTER TABLE `users_temp_tbl`
  ADD PRIMARY KEY (`userRowId`);

--
-- Indexes for table `user_subject_enroll`
--
ALTER TABLE `user_subject_enroll`
  ADD PRIMARY KEY (`enrolId`);

--
-- Indexes for table `user_subject_saved`
--
ALTER TABLE `user_subject_saved`
  ADD PRIMARY KEY (`sId`);

--
-- Indexes for table `user_test_ans`
--
ALTER TABLE `user_test_ans`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `user_test_result`
--
ALTER TABLE `user_test_result`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `userId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `badgeId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `articleId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cancel_courses`
--
ALTER TABLE `cancel_courses`
  MODIFY `requestId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancel_courses_history`
--
ALTER TABLE `cancel_courses_history`
  MODIFY `requestId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancel_students`
--
ALTER TABLE `cancel_students`
  MODIFY `stuCourseId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancel_students_history`
--
ALTER TABLE `cancel_students_history`
  MODIFY `stuCourseId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_instructor`
--
ALTER TABLE `change_instructor`
  MODIFY `queryId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_instructor_history`
--
ALTER TABLE `change_instructor_history`
  MODIFY `queryId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `chapterId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `chapter_carriculum_media`
--
ALTER TABLE `chapter_carriculum_media`
  MODIFY `mediaId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `pageId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `courses_chapters_bak`
--
ALTER TABLE `courses_chapters_bak`
  MODIFY `couChaId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_chapters`
--
ALTER TABLE `course_chapters`
  MODIFY `courseDetailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `course_instructors`
--
ALTER TABLE `course_instructors`
  MODIFY `courseInsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `course_level_details`
--
ALTER TABLE `course_level_details`
  MODIFY `crsLvlId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `course_review`
--
ALTER TABLE `course_review`
  MODIFY `reviewId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instructor_schedule_time`
--
ALTER TABLE `instructor_schedule_time`
  MODIFY `scheduleTimeId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lessonId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `packageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `quesId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions_options`
--
ALTER TABLE `questions_options`
  MODIFY `optionId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quizId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
  MODIFY `reasonId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule_calendar`
--
ALTER TABLE `schedule_calendar`
  MODIFY `sid` bigint(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_conference_tbl`
--
ALTER TABLE `session_conference_tbl`
  MODIFY `conferenceId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settingId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_booked_classes`
--
ALTER TABLE `student_booked_classes`
  MODIFY `classId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_booked_classes_history`
--
ALTER TABLE `student_booked_classes_history`
  MODIFY `classId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_cancelled_courses`
--
ALTER TABLE `student_cancelled_courses`
  MODIFY `purchaseId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_course_whishlist`
--
ALTER TABLE `student_course_whishlist`
  MODIFY `wishId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_purchased_courses`
--
ALTER TABLE `student_purchased_courses`
  MODIFY `purchaseId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subjectId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `testId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users_temp_tbl`
--
ALTER TABLE `users_temp_tbl`
  MODIFY `userRowId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_subject_enroll`
--
ALTER TABLE `user_subject_enroll`
  MODIFY `enrolId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_subject_saved`
--
ALTER TABLE `user_subject_saved`
  MODIFY `sId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_test_ans`
--
ALTER TABLE `user_test_ans`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_test_result`
--
ALTER TABLE `user_test_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
