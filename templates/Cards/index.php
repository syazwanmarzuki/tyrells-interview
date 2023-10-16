<form id="cardDistributionForm" action="<?= $this->Url->build(['controller' => 'Cards', 'action' => 'distribute'], ['fullBase' => true]); ?>" class="form-inline">
    <div class="form-group">
        <label for="numPeople">Number of People:</label>
        <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]); ?>
        <input type="number" id="numPeople" name="numPeople" class="form-control" min="1">
    </div>
    <button type="submit" class="btn btn-primary">Distribute Cards</button>
</form>


<div id="result" class="mt-3"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#cardDistributionForm').submit(function(e) {
            e.preventDefault();

            const numPeople = $('#numPeople').val();

            if (numPeople < 1 || numPeople > 53) {
                $('#result').html('Input value does not exist or value is invalid');
            } else {
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.error) {
                            $('#result').html(response.message);
                        } else {
                            $('#result').html(response.payload);
                        }
                    }
                });
            }
        });
    });
</script>