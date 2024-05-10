            <!-- Silme Onay Modalı -->
<div class="modal fade" id="nickSettingsModal" tabindex="-1" aria-labelledby="exceptionUpdateModalLabel"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Nick Ayarları</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-dark">
            <Form>
               <input type="hidden" id="modalPlayerId">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="exception" id="exception1" value="1" data-exception-value="1">
                  <label class="form-check-label" for="exception1">
                      Tek Kullanımlık
                  </label>
              </div>
              <div class="form-check">
                  <input class="form-check-input" type="radio" name="exception" id="exception2" value="2" data-exception-value="2">
                  <label class="form-check-label" for="exception2">
                      Sınırsız
                  </label>
              </div>
              <div class="form-check">
                  <input class="form-check-input" type="radio" name="exception" id="exception3" value="3" data-exception-value="3">
                  <label class="form-check-label" for="exception3">
                      İstisna Yok
                  </label>
              </div>
            </Form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
            <button type="button" class="btn btn-danger confirmException" id="confirmException">Kaydet</button>
        </div>
        </div>
    </div>
    </div>