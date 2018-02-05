<?php
namespace App\Repositories\Description;

use App\Models\Description;
use Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

/**
 * Class TaskRepository
 * @package App\Repositories\Description
 */
class DescriptionRepository implements DescriptionRepositoryContract
{
    const CREATED = 'created';
    const UPDATED_ASSIGN = 'updated_assign';

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Description::findOrFail($id);
    }

    /**
     * @param $requestData
     * @return mixed
     */
    public function create($requestData)
    {
        // Save the attached file
        $filename = NULL;
        if($requestData->hasFile('image'))
        {
            $file = $requestData->file('image');
            $filename = time() . '.' . $file->getClientOriginalName();
            $location = public_path('upload/');
            if (!file_exists($location)) {
                mkdir($location,0777,true);
            }
            $requestData->file('image')->move($location, $filename);
        }

        $input = $requestData = array_merge(
            $requestData->all(),
            ['user_id' => auth()->id(),
                'image' => $filename]
        );
        $description = Description::create($input);

        // Create new ticket according to this ticket description
        $ticket = new Ticket();
        $ticket->status_id = 1;
        $ticket->description_id = $description->id;
        $ticket->save();

        $insertedId = $description->id;
        Session()->flash('flash_message', 'Ticket successfully added!');
        event(new \App\Events\DescriptionAction($description, self::CREATED));

        return $insertedId;
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function updateAssign($id, $requestData)
    {
        $description = Description::with('user')->findOrFail($id);

        $input = $requestData->get('user_id');

        $input = array_replace($requestData->all());
        $description->fill($input)->save();
        $description = $description->fresh();

        event(new \App\Events\DescriptionAction($description, self::UPDATED_ASSIGN));
    }

    /**
     * Statistics for Dashboard
     */

    public function descriptions()
    {
        return Description::all()->count();
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function leaderConfirm($id, $requestData)
    {
        $description = Description::with('user')->findOrFail($id);
        $input = $requestData = array_merge(
            $requestData->all(),
            [   'leader_confirmation_result' => $requestData->leader_confirmation_result]
        );

        $description->fill($input)->save();
        $description = $description->fresh();
    }
}
