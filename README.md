# Laravel Nova Break Out

Use validation rules and other data from a [Laravel Nova](https://nova.laravel.com/) resources in order to avoid
duplicate content maintenance.

_Sorry for the name of the package. My creativity with names is on low level._

## Install

```shell
composer require norman-huth/nova-breack-out
```

## Usage

### Validation

#### Get Creation Validation Rules From A Nova Resource

```php
    public function store(\Illuminate\Http\Request $request)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);

        $rules = $nova->getRulesForCreation(
            model: \App\Models\User::class,
            resource: \App\Nova\Resources\User::class
        );
```

#### Validate Request With Creation Rules From A Nova Resource

```php
    public function store(\Illuminate\Http\Request $request)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);

        $validated = $nova->validateCreationRequest(
            model: \App\Models\User::class,
            resource: \App\Nova\Resources\User::class
        );
```

#### Get Update Validation Rules From A Nova Resource

```php
    public function update(\Illuminate\Http\Request $request, \App\Models\User $user)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);

        $rules = $nova->getRulesForUpdate(
            model: $user,
            resource: \App\Nova\Resources\User::class
        );
```

#### Validate Request With Update Rules From A Nova Resource

```php
    public function update(\Illuminate\Http\Request $request, \App\Models\User $user)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);

        $validated = $nova->validateUpdateRequest(
            model: $user,
            resource: \App\Nova\Resources\User::class
        );
```

### Authorization From Nova Resource

#### ViewAny

```php
    public function index(\Illuminate\Http\Request $request)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);
        $nova->authorizeToViewAny(
            model: \App\Models\User::class,
            resource: \App\Nova\Resources\User::class
        );
```

#### Create

```php
    public function store(\Illuminate\Http\Request $request)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);
        $nova->authorizeToCreate(
            model: \App\Models\User::class,
            resource: \App\Nova\Resources\User::class
        );
```

#### View

```php
    public function show(\Illuminate\Http\Request $request, \App\Models\User $user)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);
        $nova->authorizeToView(
            model: $user,
            resource: \App\Nova\Resources\User::class
        );
```

#### Update

```php
    public function update(\Illuminate\Http\Request $request, \App\Models\User $user)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);
        $nova->authorizeToUpdate(
            model: $user,
            resource: \App\Nova\Resources\User::class
        );
```

#### Delete

```php
    public function destroy(\Illuminate\Http\Request $request, \App\Models\User $user)
    {
        $nova = new \NormanHuth\NovaBreakOut\Resource($request);
        $nova->authorizeToDelete(
            model: $user,
            resource: \App\Nova\Resources\User::class
        );
```

### More Infos From Nova Resource

### Get the displayable label of the resource.

```php
$nova = new \NormanHuth\NovaBreakOut\Resource($request);

return $nova->label(resource: \App\Nova\Resources\User::class);
```

### Get the displayable singular label of the resource.

```php
$nova = new \NormanHuth\NovaBreakOut\Resource($request);

return $nova->singularLabel(resource: \App\Nova\Resources\User::class);
```

### Get the value that should be displayed to represent the resource.

```php
$nova = new \NormanHuth\NovaBreakOut\Resource($request);

return $nova->title(resource: \App\Nova\Resources\User::class);
```

### Get the search result subtitle for the resource.

```php
$nova = new \NormanHuth\NovaBreakOut\Resource($request);

return $nova->subtitle(resource: \App\Nova\Resources\User::class);
```

### Get the logical group associated with the resource.

```php
$nova = new \NormanHuth\NovaBreakOut\Resource($request);

return $nova->group(resource: \App\Nova\Resources\User::class);
```

### Get the searchable columns for the resource.

```php
$nova = new \NormanHuth\NovaBreakOut\Resource($request);

return $nova->searchableColumns(resource: \App\Nova\Resources\User::class);
```

## Todo

* Relation rules

---

[![More Laravel Nova Packages](https://raw.githubusercontent.com/Muetze42/asset-repo/main/svg/more-laravel-nova-packages.svg)](https://huth.it/nova-packages)

[![Stand With Ukraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://vshymanskyy.github.io/StandWithUkraine/)

[![Woman. Life. Freedom.](https://raw.githubusercontent.com/Muetze42/Muetze42/2033b219c6cce0cb656c34da5246434c27919bcd/files/iran-banner-big.svg)](https://linktr.ee/CurrentPetitionsFreeIran)
