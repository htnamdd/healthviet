<?php
declare(strict_types=1);

namespace Healthviet\Directory\Ui\Component\Listing\Column;

class RegionActions extends AbstractActions
{

    /**
     * Primary field name
     *
     * @var string
     */
    const PRIMARY_FIELD = 'region_id';

    /**
     * Url path  to edit
     *
     * @var string
     */
    const URL_PATH_EDIT = 'healthviet_directory/region/edit';
    /**
     * Url path  to delete
     *
     * @var string
     */
    const URL_PATH_DELETE = 'healthviet_directory/region/delete';

}
