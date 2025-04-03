```
erDiagram
    users ||--o{ violations : "melanggar"
    users ||--o{ violations : "memberikan"
    users ||--|{ departments : "belongs_to"
    users ||--|{ generations : "belongs_to"
    users ||--|{ classes : "belongs_to"
    classes ||--|{ departments : "belongs_to"
    classes ||--|{ generations : "belongs_to"
    violations ||--|| rules : "mengacu"
    
    users {
        bigint id PK
        string name
        string email
        timestamp email_verified_at
        string password
        enum role
        bigint department_id FK
        bigint generation_id FK
        bigint class_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    password_reset_tokens {
        string email PK
        string token
        timestamp created_at
    }
    
    sessions {
        string id PK
        bigint user_id FK
        string ip_address
        text user_agent
        longtext payload
        integer last_activity
    }
    
    cache {
        string key PK
        mediumtext value
        integer expiration
    }
    
    cache_locks {
        string key PK
        string owner
        integer expiration
    }
    
    jobs {
        bigint id PK
        string queue
        longtext payload
        unsignedTinyInteger attempts
        unsignedInteger reserved_at
        unsignedInteger available_at
        unsignedInteger created_at
    }
    
    job_batches {
        string id PK
        string name
        integer total_jobs
        integer pending_jobs
        integer failed_jobs
        longtext failed_job_ids
        mediumtext options
        integer cancelled_at
        integer created_at
        integer finished_at
    }
    
    failed_jobs {
        bigint id PK
        string uuid
        text connection
        text queue
        longtext payload
        longtext exception
        timestamp failed_at
    }
    
    departments {
        bigint id PK
        string name
        timestamp created_at
        timestamp updated_at
    }
    
    generations {
        bigint id PK
        string year
        timestamp created_at
        timestamp updated_at
    }
    
    classes {
        bigint id PK
        string name
        bigint department_id FK
        bigint generation_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    rules {
        bigint id PK
        string rule
        integer points
        timestamp created_at
        timestamp updated_at
    }
    
    violations {
        bigint id PK
        bigint user_id FK
        bigint teacher_id FK
        bigint rule_id FK
        text reason
        text punishment
        timestamp created_at
        timestamp updated_at
    }```
