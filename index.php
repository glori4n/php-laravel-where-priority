<?php

/* This function's SQL output will be: "select * from calendar where user_id = ? and (starts_at in (?, ?) or ends_at in (?, ?)) and calendar.deleted_at is null"
It will first get the dates on those two ranges then afterwards applay the user's ID. */

public function checkDate(Request $request): array
    {

        $start = $request->get('start');
        $end = $request->get('end');

        $match_start = Calendar::where('user_id', auth()->user()->id)
                ->where(function ($query) use ($start, $end) {
                            $query->whereIn('starts_at', [$start, $end])
                                  ->orWhereIn('ends_at', [$start, $end]);
                        }
                    )->first();

        if($match_start){
            return [
                'success' => false,
                'msg' => __('Choose a different time.')
            ];
        }else{
            return [
                'success' => true
            ];
        }
    }

?>