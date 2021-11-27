
# Symfony 5 Proof of Concept Project

This project aims to demontrate a simple Rest Api implementation, Many-To-Many entities relationship, Symfony console command creation and CSV file importing.


## Installation

Install my-project with docker-compose

```bash
  docker-compose up -d
```
    
## Importation Command

```bash
~$ symfony console app:import-posts ./file-name.csv
```


## API Reference

### **Tag Entity**
#### GET ALL TAGS

```http
  GET /api/v1/tags?page=${page}&limit=${limit}
```

#### Query String Parameters
| Parameter | Type     | Description                  |
| :-------- | :------- | :--------------------------- |
| `page`    | `string` | **Optional**. Page number    |
| `limit`   | `string` | **Optional**. Items per page |

###
#### CREATE TAG

```http
  POST /api/v1/tags
```

#### JSON Body Parameters
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `tag`     | `string` | **Required**. Tag name            |
| `posts`   | `integer[]` | **Optional**. Array of integer with Post Entity ID |

###
#### UPDATE TAG

```http
  PATCH /api/v1/tags
```

#### JSON Body Parameters
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `tag`     | `string` | **Optional**. Tag name            |
| `posts`   | `integer[]` | **Optional**. Array of integer with Post Entity ID |

###
#### DELETE TAG

```http
  DELETE /api/v1/tags/${tagId}
```

#### URL Parameter
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `tagId`   | `integer` | **Required**. Tag ID             |

### **Post Entity**
#### GET ALL POSTS

```http
  GET /api/v1/posts?page=${page}&limit=${limit}
```

#### Query String Parameters
| Parameter | Type     | Description                  |
| :-------- | :------- | :--------------------------- |
| `page`    | `string` | **Optional**. Page number    |
| `limit`   | `string` | **Optional**. Items per page |

###
#### CREATE POST

```http
  POST /api/v1/posts
```

#### JSON Body Parameters
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`     | `string`    | **Required**. Post title        |
| `content`   | `string`    | **Required**. Post HTML Content |
| `image`     | `url`       | **Required**. Image url |
| `tags`      | `integer[]` | **Optional**. Array of integer with Tag Entity ID |

###
#### UPDATE POST

```http
  PATCH /api/v1/posts
```

#### JSON Body Parameters
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `title`     | `string`    | **Optional**. Post title        |
| `content`   | `string`    | **Optional**. Post HTML Content |
| `image`     | `url`       | **Optional**. Image url |
| `tags`      | `integer[]` | **Optional**. Array of integer with Tag Entity ID |

###
#### DELETE POST

```http
  DELETE /api/v1/posts/${postId}
```

#### URL Parameter
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `postId`  | `integer`| **Required**. Post ID             |

