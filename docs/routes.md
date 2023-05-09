To create routes for regular system used `route.php` file. To create routes for tenants - `tenant.php`.


# Custom helpers

## CustomRoute::CRUD
To create routes for standard CRUD operations you should use `CustomRoute::CRUD('resource', ResourceController::class)`. This creates named routes using standard Laravel conventions (index, show, create, store, edit, update, destroy) for controller methods. There's also ability to create `remove-draft`, `add-comment` routes using params.
In addition this helper add middleware permission for each of the routes.
If you need some of the actions not to work eg. `delete` - just leave empty controller's `destroy` method.

## CustomRoute::workflowRoutes
Register routes related to workflow.