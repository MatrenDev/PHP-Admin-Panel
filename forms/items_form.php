<fieldset>
    <div class="form-group">
        <label for="nazwa">Nazwa *</label>
          <input type="text" name="nazwa" value="<?php echo htmlspecialchars($edit ? $item['nazwa'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Nazwa" class="form-control" required="required" id = "nazwa">
    </div> 



    <div class="form-group">
        <label for="historia">Historia sprzętu</label>
          <textarea name="historia" placeholder="Historia sprzętu" class="form-control" id="historia"><?php echo htmlspecialchars(($edit) ? $item['historia'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    <div class="form-group">
        <label>Data wydania</label>
        <input name="wydanie" value="<?php echo htmlspecialchars($edit ? $item['wydanie'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Data wydania" class="form-control" type="date">
    </div>

    <div class="form-group">
        <label for="pomieszczenie">Pomieszczenie</label>
        <input name="pomieszczenie" value="<?php echo htmlspecialchars($edit ? $item['pomieszczenie'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="987654321" class="form-control"  type="text" id="pomieszczenie">
    </div>


    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Zapisz <i class="glyphicon glyphicon-send"></i></button>
    </div>
</fieldset>
