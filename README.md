# tpe3web2-api-rest
# 📺 API REST - Temporadas y Capítulos

Este proyecto implementa una API RESTful para gestionar temporadas y capítulos de series. Está diseñado para integrarse con otros sistemas, como aplicaciones móviles o sitios externos. La base de datos es compartida con el proyecto original del TPE Web2.

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
  },
  ...
]

