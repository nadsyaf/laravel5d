# ERD Laravel5D - Beauty Booking System

Layanan NailArt & LashExtension. Nadiya Syafa - 2410010577 - TI 5D REG BJB

```mermaid
erDiagram
    users ||--o{ bookings : "membuat"
    beauticians ||--o{ bookings : "menangani"
    bookings ||--o{ booking_service : "berisi"
    services ||--o{ booking_service : "dipesan"
    categories ||--o{ services : "memiliki"

    users {
        bigint id PK
        varchar name
        varchar email UK
        varchar password
        varchar phone
        enum role "admin, customer"
        timestamp created_at
    }

    beauticians {
        bigint id PK
        varchar name
        varchar specialty
        varchar photo
        enum status "active, inactive"
        timestamp created_at
    }

    categories {
        bigint id PK
        varchar name
        varchar slug UK
    }

    services {
        bigint id PK
        bigint category_id FK
        varchar name
        text description
        decimal price
        int duration_minutes
        varchar photo
    }

    bookings {
        bigint id PK
        varchar booking_code UK
        bigint user_id FK
        bigint beautician_id FK
        date booking_date
        time start_time
        decimal total_price
        enum status "pending, confirmed, completed, canceled"
        text notes
        timestamp created_at
    }

    booking_service {
        bigint id PK
        bigint booking_id FK
        bigint service_id FK
        decimal price "harga saat booking dibuat"
    }
```

Keterangan: PK = primary key, FK = foreign key, UK = unique.
Relasi `bookings` dan `services` bersifat many-to-many melalui tabel `booking_service`.
