function runeditor()
{
  $('#summernote').summernote({
    placeholder: 'Text článku...',
    tabsize: 2,
    height: 600,
    toolbar: [
      ['font', ['bold', 'underline', 'clear']],
      ['para', ['ul', 'ol']],
      ['insert', ['link']],
      ['view', ['codeview', 'help']]
    ]
  });
}