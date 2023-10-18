<div class="form-group mb-3">
    <label class="control-label">{{ __('Address') }}</label>
    {!! Form::input('text', 'address', $content, ['class' => 'form-control', 'data-shortcode-attribute' => 'content', 'placeholder' => '24 Roberts Street, SA73, Chester']) !!}
</div>
    <div class="form-group mb-3">
        <label class="control-label">{{ __('Class') }}</label>
        {!! Form::input('text', 'class', $class, ['class' => 'form-control', 'data-shortcode-attribute' => 'class', 'placeholder' => 'col-5 w-100']) !!}
    </div>
        <div class="form-group mb-3">
            <label class="control-label">{{ __('Style') }}</label>
            {!! Form::input('text', 'style', $style, ['class' => 'form-control', 'data-shortcode-attribute' => 'style', 'placeholder' => 'height:400px;width: 100%; position: relative; text-align: right;']) !!}
</div>
<div class="form-group mb-3">
            <label class="control-label">{{ __('Map Height') }}</label>
            {!! Form::input('text', 'height', $height, ['class' => 'form-control', 'data-shortcode-attribute' => 'height', 'placeholder' => '400 all is pixels']) !!}
</div>
