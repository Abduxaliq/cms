
<div class="form-group">
    <label class="control-label col-md-2 col-sm-2 col-xs-12">
        {{ $lblName }}
    </label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        {{ Form::text($name, $value, array_merge(['class' => 'form-control col-md-7 col-xs-12', 'autocomplete'=>'off'], $attributes)) }}
    </div>
</div>