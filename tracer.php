<?php

function getTrace()
{
    $e = new Exception();
    $stack_trace = "\n" . print_r(str_replace(__DIR__, '', getExceptionTraceAsString($e, 4)), true) . " \n";
    return $stack_trace;
}


function getExceptionTraceAsString($exception, $max = 999)
{
    $rtn = "";
    $count = 0;
    foreach ($exception->getTrace() as $frame) {
        $args = "";
        if (isset($frame['args'])) {
            $args = array();
            foreach ($frame['args'] as $arg) {
                if (is_string($arg)) {
                    $args[] = "'" . $arg . "'";
                } elseif (is_array($arg)) {
                    $args[] = "Array";
                } elseif (is_null($arg)) {
                    $args[] = 'NULL';
                } elseif (is_bool($arg)) {
                    $args[] = ($arg) ? "true" : "false";
                } elseif (is_object($arg)) {
                    $args[] = get_class($arg);
                } elseif (is_resource($arg)) {
                    $args[] = get_resource_type($arg);
                } else {
                    $args[] = $arg;
                }
            }
            $args = join(", ", $args);
        }
        $args = substr($args, 0, 64);
        $rtn .= sprintf("#%s %s:%s %s(%s)\n", $count, $frame['file'], $frame['line'], $frame['function'], $args);
        $count++;

        if ($count > $max) {
            break;
        }
    }
    return $rtn;
}
