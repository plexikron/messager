<?php

declare(strict_types=1);

namespace Chronhub\Messager\Message;

// ??stick to interface
// or do we need values
enum Header : string
{
    case EVENT_ID = '__event_id';

    case EVENT_TYPE = '__event_type';

    case EVENT_TIME = '__event_time';

    case REPORTER_NAME = '__reporter_name';

    case ASYNC_MARKER = '__async_marker';

    case AGGREGATE_ID = '__aggregate_id';

    case AGGREGATE_ID_TYPE = '__aggregate_id_type';

    case AGGREGATE_TYPE = '__aggregate_type';

    case AGGREGATE_VERSION = '__aggregate_version';

    case INTERNAL_POSITION = '__internal_position';

    case EVENT_CAUSATION_ID = '__event_causation_id';

    case EVENT_CAUSATION_TYPE = '__event_causation_type';
}
