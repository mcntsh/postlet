<?php

namespace api\modules\v1\enums;

abstract class ErrorEnum {
  const Invalid   = 'INVALID';
  const Missing   = 'MISSING';
  const Malformed = 'MALFORMED';
  const Exists    = 'EXISTS';
}
