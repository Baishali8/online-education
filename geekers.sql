-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2023 at 07:52 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geekers`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `user_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`user_id`, `playlist_id`) VALUES
('CrlPqywBX28klRR1Vkvz', 'zJ70RijIQifWp0kR5afS');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content_id`, `user_id`, `tutor_id`, `comment`, `date`) VALUES
('V3MTLR7dDYCMsMGGTcjI', 'Oqes2dQIT0gogyLuS1dj', 'CrlPqywBX28klRR1Vkvz', 'm7N9R7PLKVPFzWZQ3gCe', 'This is a comment. Testing 1', '2023-06-27');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `number`, `message`) VALUES
('Baishali', 'baishali@gmail.com', 1234567890, 'Test 2');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `playlist_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `video` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `tutor_id`, `playlist_id`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
('Oqes2dQIT0gogyLuS1dj', 'm7N9R7PLKVPFzWZQ3gCe', 'zJ70RijIQifWp0kR5afS', 'HTML Tutorial Part 1', '\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Facere itaque id inventore ipsam, beatae veniam maiores accusantium quos doloremque vel repudiandae, incidunt tempora error. Officiis perspiciatis deserunt id? Nam cum deserunt necessitatibus cupiditate et fugit aliquam eligendi nisi esse dolor quaerat nesciunt delectus, beatae similique magni asperiores omnis dolore tenetur natus dignissimos aut voluptates sint! Libero, atque reprehenderit suscipit natus, ea corrupti veritatis maiores iste dolorem aliquid, nostrum expedita omnis?', 'RIabrSRcaX7YNnVdpBx2.png', 'BZuBzQYZ5OOz7aaHsbFE.png', '2023-06-21', 'Active'),
('VHb2BrjNZAuVxVTn8pLb', '4xXqfqEosGeJ4hC1ZJ7t', 'J7kNor2hyIni7MuK660a', 'PHP Tutorial 1', 'Praesent ultrices tortor massa, ac accumsan tortor gravida sit amet. Vestibulum feugiat dolor ac erat fringilla, eget pharetra neque volutpat. Donec vulputate, eros a rutrum viverra, dolor ipsum accumsan sapien, quis feugiat ligula mi vitae ante. In consequat vestibulum gravida. In eget ultrices leo, eget feugiat velit. ', '6XR1Zp3y5C0FKp0j4mWb.png', 'tYP50XUauTNwmwyf7Rud.png', '2023-06-23', 'Active'),
('7It11GXSYP1DcOz9jYqV', 'm7N9R7PLKVPFzWZQ3gCe', 'zJ70RijIQifWp0kR5afS', 'HTML Tutorial Part 2', 'Ut lobortis placerat turpis. Sed vulputate congue dolor, ut vestibulum turpis finibus et. Mauris at nunc nunc. Etiam at finibus ex. Vestibulum ipsum libero, tincidunt pulvinar nulla vel.', 'R3Tdc3MLcUGY8uBgZjEB.png', 'Nxyy9Eo7gVeZKhShghHN.png', '2023-06-24', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `content_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `tutor_id`, `content_id`) VALUES
('CrlPqywBX28klRR1Vkvz', 'm7N9R7PLKVPFzWZQ3gCe', 'Oqes2dQIT0gogyLuS1dj'),
('CrlPqywBX28klRR1Vkvz', 'm7N9R7PLKVPFzWZQ3gCe', '7It11GXSYP1DcOz9jYqV');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` varchar(20) NOT NULL,
  `tutor_id` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `tutor_id`, `title`, `description`, `thumb`, `date`, `status`) VALUES
('zJ70RijIQifWp0kR5afS', 'm7N9R7PLKVPFzWZQ3gCe', 'Complete HTML Tutorial For Begineers', 'Vestibulum tincidunt tempus efficitur. In imperdiet risus ante, sodales viverra magna suscipit eu. Mauris eget accumsan turpis. Pellentesque non mattis lectus. Suspendisse potenti. Vestibulum malesuada felis id nibh blandit congue. Vestibulum pulvinar tellus nec sagittis sodales. ', 'zBgmfN4C5ATeWU5iCJWS.png', '2023-06-20', 'Active'),
('RtTdqvLKAASNFKEBeZkw', 'm7N9R7PLKVPFzWZQ3gCe', 'CSS Complete Tutorial', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur id ornare sapien, in egestas est. Pellentesque non cursus leo, et auctor nisl. ', 'kX0TrRfmhke6GVMWHMzM.png', '2023-06-20', 'Active'),
('QOPREPR77GpDegStn5GM', 'm7N9R7PLKVPFzWZQ3gCe', 'JavaScript Complete Tutorial', 'Donec at augue eu ligula molestie sodales. Nunc porttitor congue purus eget pretium. Phasellus efficitur ultricies pharetra. Donec ornare ante quis sollicitudin dapibus. Vivamus nunc ipsum, congue eu laoreet in, convallis in risus. Aenean dapibus eu velit eget semper. Suspendisse sed convallis ex. ', 'u0LN8sjWNu7nOlHtEKCd.png', '2023-06-20', 'Active'),
('gL2UstuTN9pZbqgyZC4z', 'm7N9R7PLKVPFzWZQ3gCe', 'React JS Tutorial', 'Cras et pretium ex. Quisque dignissim viverra blandit. Curabitur vel tortor lectus. Aenean et sem tortor. Sed fermentum est sed rhoncus vulputate. Nullam pharetra nisl neque, eu interdum mi sollicitudin eu.', '71KCI7LoVcCLTVUI34G9.png', '2023-06-23', 'Active'),
('yWBab2XKtMPv9MEUlVZs', 'm7N9R7PLKVPFzWZQ3gCe', 'JQuery Complete Playlist', 'Pellentesque vestibulum est id commodo luctus. Fusce ac commodo tellus. Pellentesque non feugiat risus. Praesent ultrices tortor massa, ac accumsan tortor gravida sit amet. Vestibulum feugiat dolor ac erat fringilla, eget pharetra neque volutpat. Donec vulputate, eros a rutrum viverra, dolor ipsum accumsan sapien, quis feugiat ligula mi vitae ante. In consequat vestibulum gravida. In eget ultrices leo, eget feugiat velit. Aliquam malesuada, dolor eu finibus auctor, felis dolor volutpat massa, eget vestibulum lorem turpis egestas dolor. Etiam sed nibh ligula.', 'FcqhU2sfXtWdodax6cZE.png', '2023-06-23', 'Active'),
('P6eXeVsWFNY9UWWn3LBX', '4xXqfqEosGeJ4hC1ZJ7t', 'SAAS Tutorial', 'Praesent ultrices tortor massa, ac accumsan tortor gravida sit amet. Vestibulum feugiat dolor ac erat fringilla, eget pharetra neque volutpat. Donec vulputate, eros a rutrum viverra, dolor ipsum accumsan sapien, quis feugiat ligula mi vitae ante. In consequat vestibulum gravida. In eget ultrices leo, eget feugiat velit. Aliquam malesuada, dolor eu finibus auctor, felis dolor volutpat massa, eget vestibulum lorem turpis egestas dolor. Etiam sed nibh ligula.', 'qlGz0dBmTbpvM9vWvKDC.png', '2023-06-23', 'Active'),
('WwaKa4Ces0NdtgPNdx6P', '4xXqfqEosGeJ4hC1ZJ7t', 'Bootstrap Complete Video', ' Aliquam malesuada, dolor eu finibus auctor, felis dolor volutpat massa, eget vestibulum lorem turpis egestas dolor. Etiam sed nibh ligula.', 'kTBxgg0cvi1Fzht1tZ77.png', '2023-06-23', 'Active'),
('J7kNor2hyIni7MuK660a', '4xXqfqEosGeJ4hC1ZJ7t', 'PHP Tutorial For Beginners', 'Vestibulum feugiat dolor ac erat fringilla, eget pharetra neque volutpat. Donec vulputate, eros a rutrum viverra, dolor ipsum accumsan sapien, quis feugiat ligula mi vitae ante. In consequat vestibulum gravida. In eget ultrices leo, eget feugiat velit. Aliquam malesuada, dolor eu finibus auctor, felis dolor volutpat massa, eget vestibulum lorem turpis egestas dolor. Etiam sed nibh ligula.', 'hq6Ax8o1hDEPewfIIxVu.png', '2023-06-23', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `name`, `profession`, `email`, `password`, `image`) VALUES
('4xXqfqEosGeJ4hC1ZJ7t', 'Oliver Queen', 'Developer', 'oliver33@queen.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sLOCx8TTY0b6EG116m3P.jpg'),
('m7N9R7PLKVPFzWZQ3gCe', 'Shawn Mendes', 'Teacher', 'shawn@yahoo.in', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ZNo3Z3rMi0xW0To5tZTN.jpg'),
('w9uwS3nKO51xJKfhT3PX', 'Baishali Dutta', 'Developer', 'baishali@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2CCrV8JDuUNPjMfmJXZu.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
('CrlPqywBX28klRR1Vkvz', 'Felicity Smoak', 'felicity@smoakgmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sH3ktnqfldFo3VD1EwcR.jpg'),
('hRMhQK7cU7MurEAbVFps', 'Shawn Mendes', 'shawn@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'O7nDbkU2LR1jRRRj7Dc2.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
