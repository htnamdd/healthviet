<?php
declare(strict_types=1);

namespace Healthviet\Directory\Ui\Component\Listing\Column;

class DistrictActions extends AbstractActions
{
    /**
     * Primary field name
     *
     * @var string
     */
    const PRIMARY_FIELD = 'district_id';

    /**
     * Url path  to edit
     *
     * @var string
     */
    const URL_PATH_EDIT = 'healthviet_directory/district/edit';
    /**
     * Url path  to delete
     *
     * @var string
     */
    const URL_PATH_DELETE = 'healthviet_directory/district/delete';

}
