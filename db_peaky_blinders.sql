-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2025 a las 18:19:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_peaky_blinders`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capitulos`
--

CREATE TABLE `capitulos` (
  `ID_capitulos` int(11) NOT NULL,
  `Titulo` varchar(25) NOT NULL,
  `Descripcion` text NOT NULL,
  `ID_temporada_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `capitulos`
--

INSERT INTO `capitulos` (`ID_capitulos`, `Titulo`, `Descripcion`, `ID_temporada_fk`) VALUES
(10, 'Episodio 1', 'Un visitante misterioso aparece en medio de las celebraciones y pone en peligro a la familia el día de la boda tan esperada de Grace y Thomas. Además, Arthur conoce a una mujer.', 7),
(12, 'Episodio 2', 'Descripción: Un visitante misterioso aparece en medio de las celebraciones y pone en peligro a la familia el día de la boda tan esperada de Grace y Thomas. Además, Arthur conoce a una mujer.', 3),
(13, 'Episodio 1', 'Episodio 1 Un visitante misterioso aparece en medio de las celebraciones y pone en peligro a la familia el día de la boda tan esperada de Grace y Thomas. Además, Arthur conoce a una mujer.', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporadas`
--

CREATE TABLE `temporadas` (
  `ID_temporada` int(11) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Fecha_estreno` date NOT NULL,
  `Productora` varchar(100) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `temporadas`
--

INSERT INTO `temporadas` (`ID_temporada`, `Nombre`, `Fecha_estreno`, `Productora`, `imagen`) VALUES
(3, 'Peaky Blinders', '2013-09-10', 'BBC Studios, Caryn Mandabach Productions y Tiger Aspect Productions', 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcR_cruxvYUrdnxvkziGe4DVWeBnJtEEJCwn8IV_axycdZf7R-9ibsTude_3jOdDLw-njfKW2Q-YRfnhraiYnNWb0SSeNgDoF6oiORAv9-wM'),
(7, 'Temporada 3', '2025-10-30', 'BBC Studios, Caryn Mandabach Productions y Tiger Aspect Productions', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSWn4sVm6ybDVah8bejE8OH3NCbZBv_UNbAyfLm--FqOn2MLDB4Q-nBd9uQleHUD_xbS_Lm9tVYB1OKB5hkdyO9RdcKLIDRR98KADOP0HqqkQ'),
(8, 'Temporada 5', '2025-10-24', 'BBC Studios, Caryn Mandabach Productions y Tiger Aspect Productions', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSWn4sVm6ybDVah8bejE8OH3NCbZBv_UNbAyfLm--FqOn2MLDB4Q-nBd9uQleHUD_xbS_Lm9tVYB1OKB5hkdyO9RdcKLIDRR98KADOP0HqqkQ'),
(11, 'Temp 2', '2025-10-26', 'Harry', 'https://es.web.img2.acsta.net/pictures/18/03/14/14/20/1756999.jpg'),
(12, 'Temporada 4', '2025-10-03', 'BBC Studios, Caryn Mandabach Productions y Tiger Aspect Productions', 'https://cdn.webshopapp.com/shops/268192/files/433182622/tommy-shelby.jpg'),
(13, 'Temp 6', '2025-11-08', 'BBC Studios, Caryn Mandabach Productions y Tiger Aspect Productions', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSWn4sVm6ybDVah8bejE8OH3NCbZBv_UNbAyfLm--FqOn2MLDB4Q-nBd9uQleHUD_xbS_Lm9tVYB1OKB5hkdyO9RdcKLIDRR98KADOP0HqqkQ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `Usuario` varchar(200) NOT NULL,
  `contraseña` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `Usuario`, `contraseña`) VALUES
(1, 'webadmin', '$2y$10$.cgeRjA95UxLT5/Oc2hbb.cZ9KPc4bYx.0k0i3ENTFxGNLIIxQFnS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `capitulos`
--
ALTER TABLE `capitulos`
  ADD PRIMARY KEY (`ID_capitulos`),
  ADD KEY `ID_serie_fk` (`ID_temporada_fk`);

--
-- Indices de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  ADD PRIMARY KEY (`ID_temporada`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `capitulos`
--
ALTER TABLE `capitulos`
  MODIFY `ID_capitulos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `temporadas`
--
ALTER TABLE `temporadas`
  MODIFY `ID_temporada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `capitulos`
--
ALTER TABLE `capitulos`
  ADD CONSTRAINT `fk_capitulo_serie` FOREIGN KEY (`ID_temporada_fk`) REFERENCES `temporadas` (`ID_temporada`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
