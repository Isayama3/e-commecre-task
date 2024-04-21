<?php

function toggleBoolean($model, $name = 'is_active', $open = 1, $close = 0)
{
    if ($model->$name == $open) {
        $model->$name = $close;
        $model->save();
    } elseif ($model->$name == $close) {
        $model->$name = $open;
        $model->save();
    } else {
        return false;
    }

    return true;
}
