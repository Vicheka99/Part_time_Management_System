# Supabase Database Setup

This Laravel backend uses Supabase as a PostgreSQL database through Eloquent.

1. Open the Supabase dashboard.
2. Go to **Project Settings > Database > Connect**.
3. Select the **Session pooler** connection for a persistent Laravel server.
4. Add its values to `backend/.env`:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=aws-0-your-region.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.your-project-ref
DB_PASSWORD=your-database-password
DB_SSLMODE=require
DB_SEARCH_PATH=public
```

Then clear cached configuration and create the tables:

```bash
php artisan optimize:clear
php artisan migrate --seed
```

Do not put the Supabase database password or service-role key in frontend code.
