<?php

namespace Bedoz\BackpackPlus\app\Library\CrudPanel\Traits;

use Backpack\CRUD\app\Library\CrudPanel\Traits\SaveActions as OriginalSaveActions;

trait SaveActions
{
    use OriginalSaveActions;

    /**
     * Redirect to the correct URL, depending on which save action has been selected.
     *
     * @param string $itemId
     *
     * @return \Illuminate\Http\Response
     */
    public function performSaveAction($itemId = null)
    {
        $saveAction = \Request::input('save_action', $this->getSaveActionDefaultForCurrentOperation());
        $itemId = $itemId ?: \Request::input('id');

        switch ($saveAction) {
            case 'save_and_new':
                $redirectUrl = $this->route.'/create';
                break;
            case 'save_and_edit':
                $redirectUrl = $this->route.'/'.$itemId.'/edit';
                if (\Request::has('locale')) {
                    $redirectUrl .= '?locale='.\Request::input('locale');
                }
                if (\Request::has('current_tab')) {
                    $redirectUrl .= '#'.\Request::get('current_tab');
                }
                break;
            case 'save_and_back':
            default:
                $redirectUrl = \Request::has('http_referrer') ? \Request::get('http_referrer') : $this->route;
                break;
        }

        if ($this->crud->request->query()) {
            $redirectUrl = parse_url($redirectUrl);
            $result = $this->crud->request->query();
            if (isset($redirectUrl['query']) && $redirectUrl['query'] != null) {
                parse_str($redirectUrl['query'], $output);
                $result = array_merge($output, $result);
            }
            $redirectUrl = $redirectUrl['path'].'?'.http_build_query($result);
        }

        // if the request is AJAX, return a JSON response
        if ($this->request->ajax()) {
            return [
                'success'      => true,
                'data'         => $this->entry,
                'redirect_url' => $redirectUrl,
            ];
        }

        return \Redirect::to($redirectUrl);
    }
}
