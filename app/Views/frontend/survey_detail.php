<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<section class="page-header">
    <div class="auto-container">
        <div class="page-header__inner">
            <h1><?= esc($survey['title']) ?></h1>
            <p>Periode <?= $survey['start_date'] ? date('d F Y', strtotime($survey['start_date'])) : '-' ?> hingga <?= $survey['end_date'] ? date('d F Y', strtotime($survey['end_date'])) : '-' ?></p>
        </div>
    </div>
</section>

<section class="survey-detail">
    <div class="auto-container">
        <div class="survey-detail__layout row clearfix">
            <div class="col-lg-8">
                <div class="survey-detail__content">
                    <div class="survey-detail__status <?= $isOpen ? 'is-open' : 'is-closed' ?>">
                        <?= $isOpen ? 'Survei sedang berlangsung' : 'Survei telah ditutup' ?>
                    </div>

                    <?php if (!empty($survey['description'])): ?>
                        <div class="survey-detail__description">
                            <?= $survey['description'] ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success">
                            <div class="alert__content">
                                <span class="icon-check"></span>
                                <p><?= esc($successMessage) ?></p>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <div class="alert__content">
                                <span class="icon-warning"></span>
                                <ul class="list-style-one">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= esc(is_array($error) ? implode(' ', $error) : $error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ($isOpen): ?>
                        <form action="<?= base_url('survey/' . $survey['id'] . '/submit') ?>" method="post" class="survey-form form-style-one">
                            <?= csrf_field() ?>

                            <?php if (!(int) $survey['is_anonymous']): ?>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Lengkap <span class="required">*</span></label>
                                            <input type="text" name="respondent_name" value="<?= old('respondent_name') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="respondent_email" value="<?= old('respondent_email') ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="survey-detail__note">Survei ini anonim. Identitas Anda tidak akan disimpan.</p>
                            <?php endif ?>

                            <div class="survey-form__questions">
                                <?php foreach ($survey['questions'] as $index => $question): ?>
                                    <?php $field = 'question_' . $question['id']; ?>
                                    <div class="survey-question">
                                        <label>
                                            <span class="survey-question__number"><?= $index + 1 ?>.</span>
                                            <span class="survey-question__text"><?= esc($question['question']) ?></span>
                                            <?php if ((int) $question['is_required']): ?>
                                                <span class="required">*</span>
                                            <?php endif ?>
                                        </label>

                                        <div class="survey-question__control">
                                            <?php $fieldError = $errors[$field] ?? null; ?>

                                            <?php switch ($question['type']) {
                                                case 'textarea': ?>
                                                    <textarea name="<?= $field ?>" rows="3" <?= (int) $question['is_required'] ? 'required' : '' ?>><?= old($field) ?></textarea>
                                                <?php break;

                                                case 'radio': ?>
                                                    <?php foreach ((array) ($question['options'] ?? []) as $option): ?>
                                                        <div class="form-check">
                                                            <label>
                                                                <input type="radio" name="<?= $field ?>" value="<?= esc($option) ?>" <?= old($field) === $option ? 'checked' : '' ?> <?= (int) $question['is_required'] ? 'required' : '' ?>>
                                                                <span><?= esc($option) ?></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php break;

                                                case 'checkbox': ?>
                                                    <?php $selected = (array) old($field); ?>
                                                    <?php foreach ((array) ($question['options'] ?? []) as $option): ?>
                                                        <div class="form-check">
                                                            <label>
                                                                <input type="checkbox" name="<?= $field ?>[]" value="<?= esc($option) ?>" <?= in_array($option, $selected, true) ? 'checked' : '' ?>>
                                                                <span><?= esc($option) ?></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php break;

                                                case 'select': ?>
                                                    <select name="<?= $field ?>" <?= (int) $question['is_required'] ? 'required' : '' ?>>
                                                        <option value="">-- Pilih --</option>
                                                        <?php foreach ((array) ($question['options'] ?? []) as $option): ?>
                                                            <option value="<?= esc($option) ?>" <?= old($field) === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                <?php break;

                                                default: ?>
                                                    <input type="text" name="<?= $field ?>" value="<?= old($field) ?>" <?= (int) $question['is_required'] ? 'required' : '' ?>>
                                                <?php break;
                                            } ?>

                                            <?php if ($fieldError): ?>
                                                <small class="form-error"><?= esc(is_array($fieldError) ? implode(' ', $fieldError) : $fieldError) ?></small>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>

                            <div class="survey-form__actions text-center">
                                <button type="submit" class="thm-btn"><span class="txt">Kirim Tanggapan</span></button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <div class="alert__content">
                                <span class="icon-warning"></span>
                                <p>Survei ini telah ditutup. Terima kasih atas partisipasi Anda.</p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>

            <div class="col-lg-4">
                <aside class="survey-detail__sidebar">
                    <div class="survey-summary">
                        <h3>Ringkasan Survei</h3>
                        <ul class="list-style-one">
                            <li><strong>Status:</strong> <?= $isOpen ? 'Sedang Berlangsung' : 'Ditutup' ?></li>
                            <li><strong>Tipe:</strong> <?= $survey['type'] === 'poll' ? 'Jajak Pendapat' : 'Kuesioner' ?></li>
                            <li><strong>Anonym:</strong> <?= (int) $survey['is_anonymous'] ? 'Ya' : 'Tidak' ?></li>
                            <li><strong>Total Responden:</strong> <?= number_format($responseCount) ?></li>
                            <?php if (!empty($survey['max_responses'])): ?>
                                <li><strong>Batas Respon:</strong> <?= number_format($survey['max_responses']) ?> respon</li>
                            <?php endif ?>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
