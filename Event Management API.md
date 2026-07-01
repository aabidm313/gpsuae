# Event Management API

Base URL:
```text
http://localhost:8000/api
```

## Headers

Use these headers in requests:

```http
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN
```

> `Authorization` is required only for protected routes.

---

# Authentication

## Register

**POST** `/register`

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```

Returns user details and an authentication token.

---

## Login

**POST** `/login`

```json
{
  "email": "john@example.com",
  "password": "secret123"
}
```

Returns an authentication token.

---

## Logout

**POST** `/logout`

Requires authentication.

---

## Forgot Password

**POST** `/password/forgot`

```json
{
  "email": "john@example.com"
}
```

---

## Reset Password

**POST** `/password/reset`

```json
{
  "token": "reset-token",
  "email": "john@example.com",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

---

# Events

## Get All Events

**GET** `/events`

Requires authentication.

---

## Get Event

**GET** `/events/{id}`

Requires authentication.

Example:

```text
GET /events/1
```

---

## Create Event

**POST** `/events`

Requires authentication.

```json
{
  "title": "Laravel Conference",
  "description": "Conference for Laravel developers",
  "location": "Karachi",
  "start_datetime": "2025-09-01 09:00:00",
  "end_datetime": "2025-09-01 17:00:00",
  "max_participants": 100,
  "status": "published"
}
```

Notes:

- Start date must be in the future.
- End date must be after start date.
- `status`: `draft`, `published`, or `cancelled`.
- `max_participants` is optional.

---

## Update Event

**PUT** `/events/{id}`

Requires authentication (Organizer only).

Example:

```json
{
  "title": "Updated Event",
  "status": "cancelled"
}
```

---

## Delete Event

**DELETE** `/events/{id}`

Requires authentication (Organizer only).

---

# Event Registration

## Register for Event

**POST** `/events/{id}/register`

Requires authentication.

No request body is needed.

---

## Cancel Registration

**DELETE** `/events/{id}/register`

Requires authentication.

---

## View Participants

**GET** `/events/{id}/participants`

Requires authentication (Organizer only).

---

# Common Errors

**401 Unauthorized**

```json
{
  "message": "Unauthenticated."
}
```

**422 Validation Error**

```json
{
  "message": "Validation failed.",
  "errors": {
    "title": [
      "The title field is required."
    ]
  }
}
```

---

# Start Server

```bash
php artisan serve
```