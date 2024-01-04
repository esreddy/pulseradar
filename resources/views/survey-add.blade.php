@extends('layout')
@section('title','Survey Page')
@section('content')

<div class="container">
    <h1>Wel come to Survey Page</h1>

    <div class="container mt-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active tab1" href="#tab1" data-toggle="tab">Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab2" href="#tab2" data-toggle="tab">Areas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab3" href="#tab3" data-toggle="tab">G - Ques</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab4" href="#tab4" data-toggle="tab">L - Ques</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab5" href="#tab5" data-toggle="tab">Config</a>
        </li>
    </ul>

    <div class="tab-content mt-4">
        <div class="tab-pane fade show active" id="tab1">
            <!-- Content for Info tab -->
            <p>Info tab content goes here...</p>
            <div class="form-group row">
                <div class="col-md-12 info_form">
                    <div class="form-group col-md-4">
                        <label for="name">Survey Name</label>
                        <input type="hidden" name="hiddenId" value="<?php echo isset($survey_info->id)?$survey_info->id:''; ?>">
                        <input type="hidden" name="hiddenSurveyId" value="<?php echo isset($survey_info->surveyId)?$survey_info->surveyId:''; ?>">
                        <input type="text" class="form-control required" id="survey_name" name="survey_name" placeholder="Name" value="<?php echo isset($survey_info->name)?$survey_info->name:''; ?>" >
                        <label class="survey_name_err validate_msg"></label>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Start Date and Time</label>
                        <input type="datetime-local" class="form-control required" id="start_date_time" name="start_date_time" placeholder="Date and Time" value="<?php echo isset($survey_info->startDate)?date("Y-m-d\TH:i", strtotime($survey_info->startDate)):''; ?>">
                        <label class="start_date_time_err validate_msg"></label>
                    </div>
                    <div class="col-md-4">
                        <label for="name">End Date and Time</label>
                        <input type="datetime-local" class="form-control required" id="end_date_time" name="end_date_time" placeholder="Date and Time" value="<?php echo isset($survey_info->endDate)?date("Y-m-d\TH:i", strtotime($survey_info->endDate)):''; ?>">
                        <label class="end_date_time_err validate_msg"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 info_form">
                    <div class="col-md-4">
                        <label class="col-form-label">Type</label>
                        <div class="form-group">
                            <input class="form-check-input changeType" value="1" type="radio" name="stype" id="survey" {{ (isset($survey_info->type) && $survey_info->type == 1 || !isset($survey_info)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="survey">Survey</label>
                        </div>
                        <div class="form-group">
                            <input class="form-check-input changeType" value="2" type="radio" name="stype" id="survey1" {{ (isset($survey_info->type) && $survey_info->type == 2) ? 'checked' : '' }}>
                            <label class="form-check-label" for="survey1">Exit Poll</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label">Area Type</label>
                        <div class="form-group">
                            <input class="form-check-input changeAType" value="1" type="radio" name="atype" id="constituency_opt" {{ (isset($survey_info->areaType) && $survey_info->areaType == 1 || !isset($survey_info)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="constituency_opt">Constituency</label>
                        </div>
                        <div class="form-group">
                            <input class="form-check-input changeAType" value="2" type="radio" name="atype" id="constituency_opt1" {{ (isset($survey_info->areaType) && $survey_info->areaType == 2) ? 'checked' : '' }}>
                            <label class="form-check-label" for="constituency_opt1">Municipal Corporation</label>
                        </div>
                    </div>
                </div>
            </div>
            <br/><br/>
            <p style="text-align:center;">  <a class="btn btn-primary btnNext" >Next</a> </p>
        </div>
        <div class="tab-pane fade" id="tab2">
            <!-- Content for Areas tab -->
            <p>Areas tab content goes here...</p>
            <div class="form-group row">
                <div class="col-md-12 info_form">
                    <div class="col-md-6">
                        <label for="states">Select a State:</label>
                        <select id="states" name="states">
                            <option value="">Select a State</option> <!-- Empty default option -->
                            @foreach ($states as $id => $state)
                                <option value="{{ $id }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="constituencies">Select a Constituency:</label>
                    <select id="constituencies" name="constituencies">
                        <!-- Constituency options will be added here dynamically -->
                    </select>

                </div>
            </div>
            <br /><br />
            <p style="text-align:center;">
                <a class="btn btn-primary btnPrevious" >Previous</a>
                <a class="btn btn-primary btnNext" >Next</a>
            </p>
        </div>
        <div class="tab-pane fade" id="tab3">
            <!-- Content for G - Ques tab -->
            <p>G - Ques tab content goes here...</p>
            <div class="form-group" style="text-align:center;">
                <button type="button" class="btn btn-info btn-lg openGenQuesModal" data-toggle="modal">Add New Question</button>
                <label class="generalQue_err"></label>
            </div>

            <div class="genQuesBlock">

                <?php if(isset($survey_info->genQuesList) && !empty($survey_info->genQuesList)) {
                    $generalQues = json_decode(stripslashes($survey_info->genQuesList));

                    $genc = 0;
                foreach($generalQues as $genQues) {
                ?>

                    <div class="singleGenQues singleGenQues_<?php echo $genc ?>" key="<?php echo $genc ?>">
                        <div class="form-check innerGenQues">
                            <label class="col-form-label question_name"><?php echo $genQues->name; ?>
                            <input type="hidden" name="genQuesNameView[]" value="<?php echo $genQues->name; ?>">
                            <input type="hidden" name="genQuesTypeView<?php echo $genc; ?>[]" value="<?php echo $genQues->type; ?>">
                            <input type="hidden" name="genQuesIdView<?php echo $genc; ?>[]" value="<?php echo $genQues->questId; ?>">
                            </label><br>

                            <?php
                            if(isset($genQues->options) && count($genQues->options)) {
                                $gcnt = 0;
                                foreach($genQues->options as $gopt) {
                                ?>
                            <div class="form-group">
                                <input type="hidden" name="genQuesOptView<?php echo $genc; ?>[]" value="<?php echo $gopt->name; ?>">
                                <input class="form-check-input changeStatus" type="radio" value="<?php echo $gopt->name; ?>">
                                <label class="form-check-label question_name_options" for="Option1"><?php echo $gopt->name; ?></label>
                            </div>
                            <?php $gcnt++; } ?>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary delGenQues">Delete</button> &nbsp;<button type="button" class="btn btn-primary editGenQues">Edit</button> &nbsp;
                        </div>
                        <hr></div>
                <?php $genc++; } } ?>

            </div>
            <br /><br />
            <p style="text-align:center;">
            <a class="btn btn-primary btnPrevious" >Previous</a>
            <a class="btn btn-primary btnNext" >Next</a>
            </p>

        </div>
        <div class="tab-pane fade" id="tab4">
            <!-- Content for L - Ques tab -->
            <p>L - Ques tab content goes here...</p>
        </div>
        <div class="tab-pane fade" id="tab5">
            <!-- Content for Config tab -->
            <p>Config tab content goes here...</p>

        </div>
    </div>
</div>

@include('modals.general_question_modal')
<!-- Include your custom JavaScript file
<link href="{{ asset('assets/js/sc.js') }}" > -->
<script src="{{ asset('assets/js/sc.js') }}"></script>
<script src="{{ asset('assets/js/survey.js') }}"></script>
@endsection


