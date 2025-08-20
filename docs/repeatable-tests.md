# Repeatable Asset Tests

This feature lets refurbishers record hardware test runs on assets.

## Web UI
* Open an asset detail page and select the **Tests** tab.
* Use **Nieuwe testrun** to log a run and record component results.
* A green banner "Alle tests geslaagd" appears when the latest completed run has no failures.

## API
```
GET  /api/v1/assets/{asset}/test-runs
POST /api/v1/assets/{asset}/test-runs
GET  /api/v1/test-runs/{run}
PATCH /api/v1/test-runs/{run}
DELETE /api/v1/test-runs/{run}
GET  /api/v1/test-runs/{run}/items
POST /api/v1/test-runs/{run}/items
PATCH /api/v1/test-runs/{run}/items/{item}
```

Run payload example:
```json
{
  "test_type": "mobile",
  "status": "in_progress",
  "os_version": "Ubuntu 22.04"
}
```
`started_at` is set automatically when the run is created.

Item payload example:
```json
{
  "component": "keyboard",
  "status": "pass",
  "completed_at": "2025-01-01T10:15:00Z"
}
```
