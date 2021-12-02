<script type="text/javascript">
    $(function () {
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            startDate: "<?php echo $params['today'];?>",
        });
    });
</script>

<div class="form-group mb-2">
    <label for="date">Date</label>
    <input type="text" name="date" class="form-control datetimepicker-input" id="date" value="<?php echo $params['today'];?>" data-date="<?php echo $params['today'];?>"/>
</div>

<div class="form-group mb-2">
    <label for="date">AM/PM</label>
    <select name="ampm">
        <option value="am">AM</option>
        <option value="pm">PM</option>
    </select>
</div>
<div class="form-group mb-2">
    <label for="number">Number</label>

    <a href="#" onclick="Ossn.RandomNumber();"> <small>Random Nunber</small></a>
    <input type="number" name="number" class="form-control" id="number" placeholder="number" maxlength="6">

</div>

<div class="form-group mb-2">
    Balance: <?php echo number_format($params['wallet']->balance);?> DAK<br>
    Price: 10 DAK

</div>
<div class="controls">
    <input type="hidden" name="user_id" value="<?php echo $params['user_id']; ?>"/>
    <div class="ossn-loading ossn-hidden"></div>
    <input type="submit" class="btn btn-primary" value="Buy new number"/>
</div>
