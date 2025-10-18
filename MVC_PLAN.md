## Feature overview

- **Single-page navigation with localized rulebook content** – The landing view exposes buttons for rules, account, tracking, and digital play; the rules section combines introductory copy, player count guidance, die explanations, preparation/how-to lists, and an eight-page manual carousel that can be toggled without leaving the page.



- **Manual tracking board with rule-aware drag & drop and scoring helpers** – Players can configure table size/mode, place dinosaur tokens on board zones, and compute scores via JavaScript validators that enforce zone limits, die restrictions, and tallying rules aligned with Draftosaurus scoring.



- **Digital game mode with player selection and automated flow** – The “Juego Nuevo” flow gathers registered player emails, loads the board configured for the selected season, renders round/turn HUD, drives chip passing & die logic, and finishes by presenting ranked results.



- **User account area with profile updates and history** – Logged-in players can edit their display name, request account deletion, and review past match results loaded from the database; anonymous visitors get registration and login forms.



- **Authentication and registration endpoints** – PHP scripts handle password-hashed registration, cookie/session-based login, logout, and error redirects for invalid credentials.



- **Administrative management tools** – Admins can create, search, update, and delete player accounts (plus stubbed game controls) through AJAX-enabled tables tied to dedicated backend endpoints.





- **Game result persistence and reporting** – Completed digital games post aggregated payloads to PHP services that snapshot players, insert rows into `GAMES`/`GAME_RESULTS`, and expose user-centric history including opponent breakdowns.



- **Internationalization scaffolding** – A language resource module provides Spanish/English strings for navigation, forms, validation messaging, and standalone pages, enabling runtime language switching.

## Proposed MVC & TDD rework plan

1. **Establish domain models and repositories**
   - Model core entities (User, Game, GameResult, PlayerSnapshot) to encapsulate the database interactions currently handled inline within scripts like `back/login.php`, `admin_create_user.php`, and `save_game_results.php`.



   - Implement repositories (e.g., `UserRepository`, `GameRepository`) that wrap CRUD queries now duplicated across endpoints, including admin listings and result retrieval.



2. **Introduce controller layer**
   - Route all HTTP entry points through controllers (e.g., `AuthController`, `AccountController`, `GameController`, `AdminController`) that orchestrate model calls and choose views instead of serving logic directly from procedural files such as `back/update_user.php` and `back/delete_user.php`.



   - Provide REST-style JSON controllers for AJAX endpoints currently under `/back/` and separate HTML controllers for pages rendered in `front/index.php` and `front/game.php`.



3. **Refactor view layer**
   - Split the monolithic `front/index.php` into reusable templates/partials (layout, navigation, modal dialogs) and dedicated views per screen (rules, tracking, account, admin) to better align with MVC and ease maintenance.


   - Keep the vanilla JS front-end but organize scripts into modules per feature (e.g., `trackingBoard.js`, `scoreCalculator.js`, `adminPanel.js`) reflecting the current responsibilities within `js/index.js` and `js/admin.js`.



4. **Modularize game logic**
   - Extract pure game logic (dice constraints, chip rotation, scoring) from `js/game.js` into ES modules/classes to allow reuse and unit testing; pair them with API-backed services for persistence previously handled inline.


   - Mirror essential scoring rules on the server side (PHP service layer) so controllers can validate payloads before persisting, reusing logic from the planned JS modules for cross-validation.

5. **Database and configuration management**
   - Centralize database connectivity (e.g., `Database.php`) to manage MariaDB credentials once, replacing repeated connection code across back scripts.



   - Define migration/seed scripts for tables referenced by the prototype (`USERS`, `GAMES`, `GAME_RESULTS`) to support automated test setups.

6. **Testing strategy (TDD-first)**
   - Backend: Introduce PHPUnit, writing failing tests for repositories (e.g., user creation, duplicate detection mirroring `admin_create_user.php`) and controllers (e.g., login success/failure, admin authorization from `admin_list_users.php`). Use transaction rollbacks or dedicated test schema to isolate data.



   - Backend services: Add unit tests validating game result snapshots and retrieval logic reflected in `save_game_results.php` and `user_results.php`, ensuring JSON structures match expectations.



   - Front-end JS: Set up a lightweight test runner (e.g., Jest or web-test-runner) for modules extracted from `js/index.js` and `js/game.js`, writing tests for validation, scoring, turn progression, and dice restrictions.



   - Integration/UI: Plan browser-based acceptance scenarios (manual or automated with headless browsers) covering navigation flows in `front/index.php`, multi-language switching via `lang.js`, and admin CRUD journeys.



7. **Incremental migration roadmap**
   - Phase 1: Scaffold MVC directories, central DB config, and authentication controller; wrap existing scripts progressively while keeping routes backward compatible.
   - Phase 2: Migrate admin endpoints and tracking board calculations into services/modules with accompanying tests, ensuring the existing UI consumes the new APIs.
   - Phase 3: Port the digital game workflow, finalize view refactors, and enforce test coverage gates before decommissioning legacy procedural files.

## Testing
⚠️ Not run (not requested).
