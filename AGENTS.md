# AGENTS.md

## Build Commands

```bash
# Frontend
npm run dev          # Start Vite dev server
npm run build        # Production build
npm run lint         # ESLint with auto-fix
npm run lint:check   # ESLint check only
npm run format       # Prettier with auto-fix
npm run format:check # Prettier check only
npm run types:check  # TypeScript type checking

# Backend
php artisan serve                     # Start Laravel server
composer run dev                     # Run all dev services (server, queue, logs, vite)
vendor/bin/pint                       # Laravel Pint auto-fix
vendor/bin/pint --dirty --format agent  # Fix only modified files
```

## Test Commands

```bash
php artisan test                    # Run all tests
php artisan test --compact         # Compact output
php artisan test --compact --filter=testName  # Single test by name
php artisan make:test --pest {name} --unit    # Create unit test
php artisan make:test --pest {name}           # Create feature test
composer run test                   # Lint + run all tests
```

## Code Style

### PHP (Laravel)

- Always use curly braces for control structures, even single-line
- Use PHP 8 constructor property promotion
- Explicit return types on all methods
- Enum keys: TitleCase (e.g., `FavoritePerson`)
- Prefer PHPDoc blocks over inline comments
- Laravel conventions: `php artisan make:` for new files
- Use Form Request classes for validation (not inline)
- Use Eloquent relationships with return type hints
- Avoid `DB::`; prefer `Model::query()`
- Use `config()` not `env()` outside config files

### TypeScript/Vue

- Single root element per Vue component
- Use `defineProps` with TypeScript types
- Type-only imports: `import type { Foo } from './foo'`
- Import path alias: `@/` maps to `resources/js/*`
- Follow existing component patterns

### ESLint Import Order

```
1. builtin     (Node.js built-ins)
2. external    (npm packages)
3. internal    (@/ imports)
4. parent      (../)
5. sibling     (./)
6. index       (./index)
```

## Key Conventions

- Check sibling files for correct structure before creating new files
- Use descriptive names: `isRegisteredForDiscounts`, not `discount()`
- Reuse existing components before writing new ones
- Stick to existing directory structure
- Every change must be tested

## Skills Activation

Activate these skills when working in their domain:

| Skill                     | When to Activate                     |
| ------------------------- | ------------------------------------ |
| `wayfinder-development`   | Importing from @/actions or @/routes |
| `pest-testing`            | Writing tests, assertions, TDD       |
| `inertia-vue-development` | Vue pages, forms, navigation         |
| `tailwindcss-development` | CSS, styling, Tailwind classes       |

## Laravel-Specific

- Routes in `bootstrap/app.php` (Laravel 12 structure)
- No `app/Http/Kernel.php` - middleware in `bootstrap/app.php`
- Model casts in `casts()` method, not `$casts` property
- When modifying columns, include all existing attributes in migration
- Use `search-docs` tool for Laravel/ecosystem documentation

## Debugging

```bash
php artisan route:list           # List routes
php artisan tinker --execute "..."  # Run PHP code
php artisan config:show [key]    # Read config
php artisan list                 # List all commands
```
