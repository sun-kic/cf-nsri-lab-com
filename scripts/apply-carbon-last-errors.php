<?php

declare(strict_types=1);

$relativePath = 'vendor/nesbot/carbon/src/Carbon/Traits/Creator.php';
$path = __DIR__ . '/../' . $relativePath;

if (!file_exists($path)) {
    fwrite(STDERR, "Carbon source file not found; skipping patch.\n");
    exit(0);
}

$contents = file_get_contents($path);

if ($contents === false) {
    fwrite(STDERR, "Unable to read {$relativePath}.\n");
    exit(1);
}

$modified = false;

$needle = '        self::setLastErrors(parent::getLastErrors());';

if (strpos($contents, $needle) !== false) {
    $replacement = <<<'PHP'
        $lastErrors = parent::getLastErrors();

        if ($lastErrors === false) {
            $lastErrors = [
                'warning_count' => 0,
                'warnings' => [],
                'error_count' => 0,
                'errors' => [],
            ];
        }

        self::setLastErrors($lastErrors);
PHP;

    $contents = str_replace($needle, $replacement, $contents, $count);

    if ($count > 0) {
        $modified = true;
    }
}

$originalMethod = <<<'PHP'
    private static function setLastErrors(array $lastErrors)
    {
        static::$lastErrors = $lastErrors;
    }
PHP;

$patchedMethod = <<<'PHP'
    private static function setLastErrors($lastErrors)
    {
        if ($lastErrors === false) {
            $lastErrors = [
                'warning_count' => 0,
                'warnings' => [],
                'error_count' => 0,
                'errors' => [],
            ];
        }

        static::$lastErrors = $lastErrors;
    }
PHP;

if (strpos($contents, $originalMethod) !== false) {
    $contents = str_replace($originalMethod, $patchedMethod, $contents, $count);

    if ($count > 0) {
        $modified = true;
    }
}

$docNeedle = '@param array $lastErrors';

if (strpos($contents, $docNeedle) !== false) {
    $contents = str_replace($docNeedle, '@param array|false $lastErrors', $contents, $count);

    if ($count > 0) {
        $modified = true;
    }
}

if (!$modified && strpos($contents, 'private static function setLastErrors($lastErrors)') === false) {
    fwrite(STDERR, "Carbon patch not applied; verify Creator trait structure.\n");
    exit(1);
}

if ($modified && file_put_contents($path, $contents) === false) {
    fwrite(STDERR, "Unable to write patched Carbon file.\n");
    exit(1);
}

exit(0);
