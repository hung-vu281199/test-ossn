<div class='control-select2'>
    <div class="form-group">
<!--        <label for="categoriesSelect">Categories</label>-->
        <select name="categories[]" id="categoriesSelect" class="categories-select" style="width: 150px;">
            <option value="">Danh Mục</option>
            <?php foreach ($params['categories'] as $category) { ?>
                <option value="<?php echo $category->guid;?>"><?php echo $category->name; ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<!--<select name="categories[]" id="categoriesSelect" class="categories-select">-->
<!--    <option value="">Danh Mục</option>-->
<!--    --><?php //foreach ($params['categories'] as $category) { ?>
<!--        <option value="--><?php //echo $category->guid;?><!--">--><?php //echo $category->name; ?><!--</option>-->
<!--    --><?php //} ?>
<!--</select>-->