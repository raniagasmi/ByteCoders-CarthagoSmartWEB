<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container8iUnmAP\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container8iUnmAP/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container8iUnmAP.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container8iUnmAP\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container8iUnmAP\App_KernelDevDebugContainer([
    'container.build_hash' => '8iUnmAP',
    'container.build_id' => '65c42a20',
    'container.build_time' => 1712884411,
], __DIR__.\DIRECTORY_SEPARATOR.'Container8iUnmAP');
