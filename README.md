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

## 📂 Endpoints - Temporadas

### 🔹 GET `/api/temporadas`

Lista todas las temporadas. Permite ordenamiento, filtrado y paginación.

**Parámetros opcionales:**

| Parámetro     | Descripción                                      | Ejemplo              |
|---------------|--------------------------------------------------|----------------------|
| `order_by`    | Campo por el que ordenar                        | `Nombre`, `Fecha_estreno` |
| `order`       | Dirección de ordenamiento                       | `ASC`, `DESC`        |
| `Nombre`      | Filtrar por nombre exacto                       | `Temporada 3`        |
| `Productora`  | Filtrar por productora exacta                   | `BBC Studios`        |
| `limit`       | Cantidad de resultados por página               | `5`                  |
| `page`        | Número de página                                | `2`                  |

**Ejemplo:**

GET /api/temporadas?order_by=Fecha_estreno&order=DESC&limit=5&page=2

**Respuesta:**
```json
[
  {
    "ID_temporada": 5,
    "Nombre": "Temporada 5",
    "Fecha_estreno": "2022-02-27",
    "Productora": "BBC Studios",
    "imagen": "imagen5.jpg"
  }
]



## 📂 Endpoints - Capítulos
### 🔹 GET /api/capitulos
Lista todos los capítulos. Permite ordenamiento por campos específicos.
Parámetros opcionales:
|  |  |  | 
| order_by |  | TituloDescripcion | 
| order |  | ASCDESC | 


Ejemplo:
GET /api/capitulos?order_by=Titulo&order=DESC


Respuesta:
[
  {
    "ID_capitulos": 12,
    "Titulo": "El regreso",
    "Descripcion": "Capítulo final de la temporada",
    "ID_temporada_fk": 3
  }
]



### 🔹 GET /api/capitulos/{id}
Obtiene un capítulo específico por su ID.
Ejemplo:
GET /api/capitulos/12


Respuesta:
{
  "ID_capitulos": 12,
  "Titulo": "El regreso",
  "Descripcion": "Capítulo final de la temporada",
  "ID_temporada_fk": 3
}



### 🔹 POST /api/capitulos
Agrega un nuevo capítulo. Requiere Titulo, Descripcion e ID_temporada_fk.
Body (JSON):
{
  "Titulo": "Nuevo comienzo",
  "Descripcion": "Primer capítulo de la nueva temporada",
  "ID_temporada_fk": 4
}


Respuesta:
{
  "message": "Capitulo creado con éxito",
  "id": 13
}



### 🔹 PUT /api/capitulos/{id}
Actualiza un capítulo existente por ID.
Body (JSON):
{
  "Titulo": "Nuevo título",
  "Descripcion": "Descripción actualizada",
  "ID_temporada_fk": 4
}


Respuesta:
{
  "message": "Capitulo actualizado con éxito"
}



### 🔹 DELETE /api/capitulos/{id}
Elimina un capítulo por su ID.
Respuesta:
{
  "message": "Capitulo eliminado con éxito"
}



## 🧪 Testing con POSTMAN
Podés importar los endpoints en POSTMAN y probar:
- Filtros combinados (GET /api/temporadas?Productora=BBC Studios&limit=3)
- Validación de errores (POST /api/capitulos sin campos obligatorios)
- Respuestas en distintos estados (200, 400, 404)

## 📌 Notas finales
- La base de datos se autogenera si no existen tablas (_deploy() en los modelos).
- Las relaciones están normalizadas: cada capítulo pertenece a una temporada (ID_temporada_fk).
- El proyecto está preparado para escalar y modularizarse fácilmente.
