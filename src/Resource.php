<?php

namespace NormanHuth\NovaBreakOut;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\PerformsValidation;

class Resource
{
    use PerformsValidation;

    /**
     * The NovaRequest instance.
     *
     * @var \Laravel\Nova\Http\Requests\NovaRequest
     */
    protected NovaRequest $novaRequest;

    public function __construct(Request $request)
    {
        $this->novaRequest = NovaRequest::createFrom($request);
    }

    /**
     * Validate a update request.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param class-string $resource
     *
     * @return array
     */
    public function validateUpdateRequest(Model $model, string $resource): array
    {
        return $this->novaRequest->validate(
            $this->getRulesForUpdate($model, $resource)
        );
    }

    /**
     * Get the validation rules for a update request.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param class-string $resource
     *
     * @return array
     */
    public function getRulesForUpdate(Model $model, string $resource): array
    {
        /* @var \Laravel\Nova\Resource $resource */
        $resource = new $resource($model);
        $this->novaRequest->query->set('resourceId', $model->getKey());

        return static::rulesForUpdate($this->novaRequest, $resource);
    }

    /**
     * Validate a update request.
     *
     * @param \Illuminate\Database\Eloquent\Model|class-string $model
     * @param class-string $resource
     *
     * @return array
     */
    public function validateCreationRequest(Model|string $model, string $resource): array
    {
        return $this->novaRequest->validate(
            $this->getRulesForCreation($model, $resource)
        );
    }

    /**
     * Get the validation rules for a creation request.
     *
     * @param \Illuminate\Database\Eloquent\Model|class-string $model
     * @param class-string $resource
     *
     * @return array
     */
    public function getRulesForCreation(Model|string $model, string $resource): array
    {
        if (is_string($model)) {
            $model = new $model();
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        $resource = new $resource($model);

        return static::formatRules($this->novaRequest, $resource
            ->creationFields($this->novaRequest)
            ->applyDependsOn($this->novaRequest)
            ->withoutReadonly($this->novaRequest)
            ->withoutUnfillable()
            ->mapWithKeys(function ($field) {
                return $field->getCreationRules($this->novaRequest);
            })->all());
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param \Illuminate\Database\Eloquent\Model|class-string $model
     * @param class-string $resource
     *
     * @return void
     */
    public function authorizeToUpdate(Model|string $model, string $resource): void
    {
        if (is_string($model)) {
            $model = new $model();
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        (new $resource($model))->authorizeToUpdate($this->novaRequest);
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param \Illuminate\Database\Eloquent\Model|class-string $model
     * @param class-string $resource
     *
     * @return void
     */
    public function authorizeToCreate(Model|string $model, string $resource): void
    {
        if (is_string($model)) {
            $model = new $model();
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        (new $resource($model))->authorizeToCreate($this->novaRequest);
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param class-string $resource
     *
     * @return void
     */
    public function authorizeToView(Model $model, string $resource): void
    {
        /* @var \Laravel\Nova\Resource $resource */
        (new $resource($model))->authorizeToView($this->novaRequest);
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param \Illuminate\Database\Eloquent\Model|class-string $model
     * @param class-string $resource
     *
     * @return void
     */
    public function authorizeToViewAny(Model|string $model, string $resource): void
    {
        if (is_string($model)) {
            $model = new $model();
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        (new $resource($model))->authorizeToViewAny($this->novaRequest);
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param class-string $resource
     *
     * @return void
     */
    public function authorizeToDelete(Model $model, string $resource): void
    {
        $this->novaRequest->query->set('resourceId', $model->getKey());
        /* @var \Laravel\Nova\Resource $resource */
        (new $resource($model))->authorizeToDelete($this->novaRequest);
    }

    /**
     * Get the displayable label of the resource.
     *
     * @param string $resource
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return string
     */
    public function label(string $resource, Model $model = null): string
    {
        if ($model) {
            $resource = new $resource($model);
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        return $resource::label();
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @param string $resource
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return string
     */
    public function singularLabel(string $resource, Model $model = null): string
    {
        if ($model) {
            $resource = new $resource($model);
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        return $resource::singularLabel();
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $resource
     *
     * @return string
     */
    public function title(Model $model, string $resource): string
    {
        /* @var \Laravel\Nova\Resource $resource */
        $resource = new $resource($model);
        $this->novaRequest->query->set('resourceId', $model->getKey());

        return $resource->title();
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $resource
     *
     * @return string|null
     */
    public function subtitle(Model $model, string $resource): ?string
    {
        /* @var \Laravel\Nova\Resource $resource */
        $resource = new $resource($model);
        $this->novaRequest->query->set('resourceId', $model->getKey());

        return $resource->subtitle();
    }

    /**
     * Get the logical group associated with the resource.
     *
     * @param string $resource
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return string
     */
    public function group(string $resource, Model $model = null): string
    {
        if ($model) {
            $resource = new $resource($model);
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        return $resource::group();
    }

    /**
     * Get the searchable columns for the resource.
     *
     * @param string $resource
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return array
     */
    public function searchableColumns(string $resource, Model $model = null): array
    {
        if ($model) {
            $resource = new $resource($model);
            $this->novaRequest->query->set('resourceId', $model->getKey());
        }

        /* @var \Laravel\Nova\Resource $resource */
        return $resource::searchableColumns();
    }
}
