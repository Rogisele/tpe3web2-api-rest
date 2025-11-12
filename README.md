# 📺 API REST - Temporadas y Capítulos

Este proyecto implementa una API RESTful para gestionar **temporadas** y **capítulos** de series. Está diseñado para integrarse con otros sistemas, como aplicaciones móviles o sitios externos. La base de datos es compartida con el proyecto original del TPE Web2.

---

## 🔧 Tecnologías utilizadas

- PHP 7+
- MySQL
- PDO
- Arquitectura MVC
- JSON como formato de intercambio
- POSTMAN para pruebas

---

## ✅ Opcionales implementados

- 📄 Paginado
  - `GET /season` y `GET /chapters` aceptan `limit` y `page`
  - Permite controlar la cantidad de resultados por página

## 📂 Endpoints - Temporadas

### 🔹 GET `/api/seasons`

Lista todas las temporadas

Ejemplo:
GET tpe3web2-api-rest/api/seasons


### 🔹 GET /api/season/{id}
Obtiene una temporada específica por su ID.
Ejemplo:
GET tpe3web2-api-rest/api/season/3

Respuesta:
{"ID_temporada":3,
"Nombre":"Peaky Blinders",
"Fecha_estreno":"2013-09-10",
"Productora":"BBC Studios, Caryn Mandabach Productions y Tiger Aspect Productions",
"imagen":"https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcR_cruxvYUrdnxvkziGe4DVWeBnJtEEJCwn8IV_axycdZf7R-9ibsTude_3jOdDLw-njfKW2Q-YRfnhraiYnNWb0SSeNgDoF6oiORAv9-wM"}

### 🔹 POST /api/season
Agrega una nueva tempora. Requiere 	Nombre, Fecha_estreno,Productora e imagen.
 Ejemplo:
 POST tpe3web2-api-rest/api/season
 
 Body(JSON)
 {"Nombre":"Nuevo nombre",
 "Fecha_estreno":"Nueva fecha",
 "Productora":"Nueva productora",
 "imagen":"link nueva imagen"}
 
 Respuesta:
{
  "message": "temporada creada con éxito",
  "id": 13
}
### 🔹 PUT /api/season/{id}

Actualiza un capítulo existente por ID.
Ejemplo tpe3web2-api-rest/api/season/10


 Body(JSON)
 {"Nombre":"Nuevo nombre",
 "Fecha_estreno":"fecha actualizada",
 "Productora":"productora actualizada",
 "imagen":"link nueva imagen actualizada"}

 Respuesta:
{
  "message": "teamporada actualizada con éxito"
}

## 📂 Endpoints - Capítulos
### 🔹 GET /api/chapters
Lista todos los capítulos. Permite ordenamiento por campos específicos.
Ejemplo:
GET tpe3web2-api-rest/api/chapters

### 🔹 GET /api/chapter/{id}
Obtiene un capítulo específico por su ID.
Ejemplo:
GET tpe3web2-api-rest/api/chapter/12


Respuesta:
{
  "ID_capitulos": 12,
  "Titulo": "El regreso",
  "Descripcion": "Capítulo final de la temporada",
  "ID_temporada_fk": 3
}




### 🔹 POST /api/chapter
Agrega un nuevo capítulo. Requiere Titulo, Descripcion, Personajes e ID_temporada_fk.
Ejemplo tpe3web2-api-rest/api/chapter
Body (JSON):
{
  "Titulo": "Nuevo comienzo",
  "Descripcion": "Primer capítulo de la nueva temporada",
  "Personajes": "Tomy y Ada Shelby",
  "ID_temporada_fk": 4
}


Respuesta:
{
  "message": "Capitulo creado con éxito",
  "id": 13
}



### 🔹 PUT /api/chapter/{id}

Actualiza un capítulo existente por ID.
Ejemplo tpe3web2-api-rest/api/chapter/10

Body (JSON):
{
  "Titulo": "Nuevo título",
  "Descripcion": "Descripción actualizada",
  "Personajes": "Personajes actualizados",
  "ID_temporada_fk": 4
}


Respuesta:
{
  "message": "Capitulo actualizado con éxito"
}


## 🧪 Testing con POSTMAN
Podés importar los endpoints en POSTMAN y probar:
- Validación de errores (POST /api/capitulos sin campos obligatorios)
- Respuestas en distintos estados (200, 400, 404)

