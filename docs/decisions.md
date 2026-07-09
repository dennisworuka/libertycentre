# Decisions

- 2026-07-09: Fresh scaffold requested instead of restoring the previous Git worktree. The existing history is retained, but the application files are rebuilt from a clean Laravel 12 skeleton.
- 2026-07-09: Public frontend uses Bootstrap 5.3 from CDN plus committed `public/css/app.css`, keeping production free from a required Node build step.
