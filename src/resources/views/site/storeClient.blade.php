@extends('site.layouts.main')

@section('title', 'Cadastro de Cliente')

@section('content')
    <form action="{{ route('storeClient') }}" method="get">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" value="aaaaa"><br/>

        <h3>Endereço</h3>
        <label>Rua:</label>
        <input type="text" name="address[street]" value="aaaaa">><br/>

        <label>Número:</label>
        <input type="text" name="address[number]" value="aaaaa">><br/>

        <label>Bairro:</label>
        <input type="text" name="address[neighborhood]" value="aaaaa">><br/>

        <label>CEP:</label>
        <input type="text" name="address[zipcode]" value="12345678">><br/>

        <label>Complemento:</label>
        <input type="text" name="address[complement]" ><br/>

        <label>Cidade:</label>
        <input type="text" name="address[city]" value="aaaaa">><br/>

        <label>Estado:</label>
        <input type="text" name="address[state]" value="sp">><br/>

        <label>País:</label>
        <input type="text" name="address[country]" value="aaaaa">><br/>

        <h3>Contato</h3>
        <label>Nome:</label>
        <input type="text" name="contact[name]" value="aaaaa">><br/>

        <label>E-mail:</label>
        <input type="text" name="contact[email]" value="aaaaa@mail.com">><br/>

        <label>Telefone</label>
        <input type="text" name="contact[phone]" value="12345678910">><br/>

        <label>Relacionamento:</label>
        <input type="text" name="contact[relationship]" value="aaaaa">><br/>

        <h3>Documento</h3>
        <label>Tipo:</label>
        <input type="text" name="document[type]" value="cpf">><br/>

        <label>Valor:</label>
        <input type="text" name="document[value]" value="12345678910">>

        <label>Base64:</label>
        <input type="text" name="document[files][base64]" value="aaaaa">>



        <input type="submit" value="Cadastrar">
    </form>

@endsection
