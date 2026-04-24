module.exports = {
    apps: [
        {
            name: "laravel-web",
            script: "artisan",
            interpreter: "php",
            args: "serve --host=0.0.0.0 --port=${PORT}",
            env: { APP_ENV: "production", APP_DEBUG: "false" }
        },
        {
            name: "laravel-queue",
            script: "artisan",
            interpreter: "php",
            args: "queue:work --sleep=1 --tries=3 --timeout=90",
            env: { APP_ENV: "production", APP_DEBUG: "false" }
        }
    ]
};
