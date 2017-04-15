<?php

namespace api\modules\v1\enums;

abstract class HttpEnum {
  const Continue             = 100;
  const SwitchingProtocols   = 101; // 'Switching Protocols',
  const Processing           = 102; // 'Processing',
  const ConnectionTimeout    = 118; // 'Connection timed out',
  const Ok                   = 200; // 'OK',
  const Created              = 201; // 'Created',
  const Accepted             = 202; // 'Accepted',
  const NonAuthoratative     = 203; // 'Non-Authoritative',
  const NoContent            = 204; // 'No Content',
  const ResetContent         = 205; // 'Reset Content',
  const PartialContent       = 206; // 'Partial Content',
  const MultiStatus          = 207; // 'Multi-Status',
  const AlreadyReported      = 208; // 'Already Reported',
  const ContentDifferent     = 210; // 'Content Different',
  const IMUsed               = 226; // 'IM Used',
  const MultipleChoices      = 300; // 'Multiple Choices',
  const MovedPermanently     = 301; // 'Moved Permanently',
  const Found                = 302; // 'Found',
  const SeeOther             = 303; // 'See Other',
  const NotModified          = 304; // 'Not Modified',
  const UseProxy             = 305; // 'Use Proxy',
  const Reserved             = 306; // 'Reserved',
  const TempRedirect         = 307; // 'Temporary Redirect',
  const PermRedirect         = 308; // 'Permanent Redirect',
  const TooManyRedirect      = 310; // 'Too many Redirect',
  const BadRequest           = 400; // 'Bad Request',
  const Unauthorized         = 401; // 'Unauthorized',
  const PaymentRequired      = 402; // 'Payment Required',
  const Forbidden            = 403; // 'Forbidden',
  const NotFound             = 404; // 'Not Found',
  const MethodNotAllowed     = 405; // 'Method Not Allowed',
  const NotAcceptable        = 406; // 'Not Acceptable',
  const ProxyAuthRequired    = 407; // 'Proxy Authentication Required',
  const RequestTimeout       = 408; // 'Request Time-out',
  const Conflict             = 409; // 'Conflict',
  const Gone                 = 410; // 'Gone',
  const LengthRequired       = 411; // 'Length Required',
  const PreconditionFailed   = 412; // 'Precondition Failed',
  const EntityTooLarge       = 413; // 'Request Entity Too Large',
  const URITooLong           = 414; // 'Request-URI Too Long',
  const UnsupportedMedia     = 415; // 'Unsupported Media Type',
  const RangeUnsatisfiable   = 416; // 'Requested range unsatisfiable',
  const ExpectationFailed    = 417; // 'Expectation failed',
  const Teapot               = 418; // 'I\'m a teapot',
  const Misdirected          = 421; // 'Misdirected Request',
  const Unprocessable        = 422; // 'Unprocessable entity',
  const Locked               = 423; // 'Locked',
  const MethodFailure        = 424; // 'Method failure',
  const UnorderedCollection  = 425; // 'Unordered Collection',
  const UpgradeRequired      = 426; // 'Upgrade Required',
  const PreconditionRequired = 428; // 'Precondition Required',
  const TooManyRequests      = 429; // 'Too Many Requests',
  const HeaderTooLarge       = 431; // 'Request Header Fields Too Large',
  const RetryWith            = 449; // 'Retry With',
  const BlockedParental      = 450; // 'Blocked by Windows Parental Controls',
  const UnavailableLegal     = 451; // 'Unavailable For Legal Reasons',
  const ServerError          = 500; // 'Internal Server Error',
  const NotImplemented       = 501; // 'Not Implemented',
  const BadGateway           = 502; // 'Bad Gateway or Proxy Error',
  const Unavailable          = 503; // 'Service Unavailable',
  const GatewayTimeout       = 504; // 'Gateway Time-out',
  const VersionNotSupported  = 505; // 'HTTP Version not supported',
  const NoStorage            = 507; // 'Insufficient storage',
  const LoopDetected         = 508; // 'Loop Detected',
  const BandwidthLimit       = 509; // 'Bandwidth Limit Exceeded',
  const NotExtended          = 510; // 'Not Extended',
  const NetworkAuthRequired  = 511; // 'Network Authentication Required',
}
