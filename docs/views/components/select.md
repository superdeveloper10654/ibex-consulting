# Select dropdowns

## Example:
```
<x-form.select label="Test label" name="test-title" :options="$items" />
```


## Generates following structure:

```
<label for="test-title" class="form-label">Test label</label>
<select name="test-title" id="test-title" class="form-select select2">
    <option value="">Select</option>
    <option value="id-1">Value 1</option>
    <option value="id-2">Value 2</option>
    <option value="id-3">Value 3</option>
</select>
<div class="text-danger" data-error="test-title"></div>
<div class="text-danger">Message that will be shown when form_ajax() returns validation errror</div>
```

### Where:
  - `$items = (object) ['id-1' => 'Value 1', 'id-2' => 'Value 2', 'id-3' => 'Value 3']`;


## Accepted attributes:
 * selected="" - option with value that will be selected;
 * first-opt="" - first option text (has empty value). If empty - option will be hidden;
 * options="" - object of options like `[option_id => option_text]`. Can has another form: 
 ```
[
    (object) [
        'id'            => 'option_id',
        'text'          => 'option text' (`name` key can be used instead of `text`),
        'icon'          => 'Any html element that will be wrapped in `<span class="option-icon"></span>` tag and inserted just before option text',
        'visible_for'   => ['contract_id' => 123], (option will be visible when select element with name 'contract_id' will have value '123'. So when user selects '123' in 'contract_id' select - only these options will be visible in this element),

        ... - add other attibutes that will be added to data-* properties of <option> element (need to add `show-option-custom-attrs` to select element). So for example if you add `"custom_value" => 123` - on option it will be rendered as `data-custom_value="123"`.
    ], 
    ...
]
 ```

## Notes:
 - select will be generated using [select2.js](https://select2.org/) library;
 - in case you need to select option that depends from other selects - just select it programmatically and trigger change. All the parent selects with appropriate options will be triggered and selected automatically;