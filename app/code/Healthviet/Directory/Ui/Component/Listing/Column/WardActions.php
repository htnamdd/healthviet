<?php
declare(strict_types=1);

namespace Healthviet\Directory\Ui\Component\Listing\Column;

class WardActions extends AbstractActions
{

    /**
     * Primary field name
     *
     * @var string
     */
    const PRIMARY_FIELD = 'ward_id';

    /**
     * Url path  to edit
     *
     * @var string
     */
    const URL_PATH_EDIT = 'healthviet_directory/ward/edit';
    /**
     * Url path  to delete
     *
     * @var string
     */
    const URL_PATH_DELETE = 'healthviet_directory/ward/delete';

}
