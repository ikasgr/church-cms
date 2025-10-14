<?php
$groupTitle = $groupTitle ?? 'Pengaturan';
$groupDescription = $groupDescription ?? '';
$emptyMessage = $emptyMessage ?? 'Belum ada pengaturan untuk bagian ini.';
$settings = $settings ?? [];
?>
<div class="space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-sliders-h text-blue-500"></i><?= esc($groupTitle) ?>
        </h2>
        <?php if ($groupDescription): ?>
            <p class="text-sm text-gray-600 mt-1"><?= esc($groupDescription) ?></p>
        <?php endif; ?>
    </div>

    <?php if (empty($settings)): ?>
        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-10 text-center text-sm text-gray-600">
            <i class="fas fa-info-circle text-xl text-gray-400 mb-2"></i>
            <p><?= esc($emptyMessage) ?></p>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($settings as $setting): ?>
                <?php $fieldName = $setting['key']; ?>
                <?php $fieldValue = old($fieldName, $setting['value']); ?>
                <div class="border border-gray-200 rounded-lg p-5 space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">
                            <?= esc(ucwords(str_replace('_', ' ', $setting['key']))) ?>
                        </p>
                        <?php if (!empty($setting['description'])): ?>
                            <p class="text-xs text-gray-500 mt-1">
                                <?= esc($setting['description']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <?php if ($setting['type'] === 'textarea'): ?>
                            <textarea id="<?= esc($fieldName) ?>" name="<?= esc($fieldName) ?>" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= esc($fieldValue) ?></textarea>
                        <?php elseif ($setting['type'] === 'number'): ?>
                            <input type="number" id="<?= esc($fieldName) ?>" name="<?= esc($fieldName) ?>" value="<?= esc($fieldValue) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php elseif ($setting['type'] === 'boolean'): ?>
                            <?php $isChecked = in_array($fieldValue, ['1', 1, true, 'on'], true); ?>
                            <input type="hidden" name="<?= esc($fieldName) ?>" value="0">
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" id="<?= esc($fieldName) ?>" name="<?= esc($fieldName) ?>" value="1" class="form-checkbox text-blue-600 rounded" <?= $isChecked ? 'checked' : '' ?>>
                                <span>Aktifkan</span>
                            </label>
                        <?php elseif ($setting['type'] === 'json'): ?>
                            <textarea id="<?= esc($fieldName) ?>" name="<?= esc($fieldName) ?>" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"><?= esc($fieldValue) ?></textarea>
                            <p class="text-xs text-gray-500 mt-1">Gunakan format JSON yang valid.</p>
                        <?php else: ?>
                            <input type="text" id="<?= esc($fieldName) ?>" name="<?= esc($fieldName) ?>" value="<?= esc($fieldValue) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
