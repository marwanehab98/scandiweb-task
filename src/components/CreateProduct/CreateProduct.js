import { Navbar, Container, Nav, Form, Button, Modal } from 'react-bootstrap';
import BookComponent from './TypeComponents/BookComponent';
import DVDComponent from './TypeComponents/DVDComponent'
import FurnitureComponent from './TypeComponents/FurnitureComponent';
import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

function CreateProduct() {
    const [show, setShow] = useState(false);
    const [validated, setValidated] = useState(false);
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
    const navigate = useNavigate();
    const typeValues = ["size", "weight", "length", "width", "height"];

    const [product, setProduct] = useState({ "type": "book" });
    useEffect(() => {
    }, [product]);

    const [type, setType] = useState("book");
    useEffect(() => {
    }, [type]);

    const [errorMessage, setErrorMessage] = useState("");


    const handleTypeChange = (e) => {
        let tempProduct = {};
        Object.assign(tempProduct, product);
        let tempType = e.target.value.toLowerCase();
        tempProduct.type = tempType;
        typeValues.forEach(key => {
            delete tempProduct[key];
        });
        setProduct(tempProduct);
        setType(tempType);
    }

    const handleSubmit = (event) => {
        event.preventDefault();
        let tempProduct = {};
        Object.assign(tempProduct, product);
        tempProduct.type = type;
        setProduct(tempProduct);
        const form = event.currentTarget;
        if (form.checkValidity() === false) {
            setErrorMessage("Please, submit required data.")
            handleShow();
            setValidated(true);
        }
        else {
            let inputs = Array.from(document.getElementsByClassName("numberEntry"));
            let valid = inputs.every(input => {
                // eslint-disable-next-line eqeqeq
                if (Number(input.value) != input.value) {
                    setErrorMessage("Please, provide the data of indicated type");
                    return false;
                }
                return true
            });
            if (valid) {
                try {
                    // console.log(JSON.stringify(product))
                    fetch(process.env.REACT_APP_ADD_URL, {
                        method: 'post',
                        body: JSON.stringify(product)
                    }).then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        // console.log(data);
                        if (data.status === '200') {
                            navigate('/');
                        }
                        else {
                            setErrorMessage(data.message);
                            handleShow()
                        }
                    });
                } catch (error) {
                    alert(error)
                }

            }
            else {
                handleShow();
            }
        }
    }

    const handleData = (data) => {
        let tempProduct = { ...product, ...data };
        setProduct(tempProduct);
    }

    switch (product.type) {
        case "book":
            var typeComponent = <BookComponent data={handleData}></BookComponent>
            break;
        case "dvd":
            typeComponent = <DVDComponent data={handleData}></DVDComponent>
            break;
        case "furniture":
            typeComponent = <FurnitureComponent data={handleData}></FurnitureComponent>
            break;
        default:
            break;
    }

    return (
        <Form id='product_form' noValidate validated={validated} onSubmit={handleSubmit}>
            <Navbar
                style={{
                    "marginBottom": "20px",
                    "boxShadow": "0px 3px 3px lightGray"
                }}
                bg="dark" variant="dark">
                <Container fluid>
                    <Navbar.Brand>Product Add</Navbar.Brand>
                    <Nav variant='pills' activeKey="1" className="justify-content-end">
                        <Button variant="primary" type="submit">
                            Save
                        </Button>
                        <Nav.Link style={{ "marginLeft": "20px" }} eventKey="1" href='/'>Cancel</Nav.Link>
                    </Nav>
                </Container>
            </Navbar>
            <Container>
                <Form.Group className="mb-3">
                    <Form.Label>SKU</Form.Label>
                    <Form.Control
                        id='sku'
                        required
                        className="productDataEntry"
                        placeholder="Enter SKU"
                        onChange={(e) => {
                            let tempProduct = {};
                            Object.assign(tempProduct, product);
                            tempProduct.SKU = e.target.value;
                            setProduct(tempProduct);
                        }}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Name</Form.Label>
                    <Form.Control
                        id='name'
                        required
                        className="productDataEntry"
                        placeholder="Enter Product Name"
                        onChange={(e) => {
                            let tempProduct = {};
                            Object.assign(tempProduct, product);
                            tempProduct.name = e.target.value;
                            setProduct(tempProduct);
                        }}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Price ($)</Form.Label>
                    <Form.Control
                        id='price'
                        required
                        // type='number'
                        // step={0.01}
                        className="productDataEntry numberEntry"
                        placeholder="Enter Product Price"
                        onChange={(e) => {
                            let tempProduct = {};
                            Object.assign(tempProduct, product);
                            tempProduct.price = e.target.value;
                            setProduct(tempProduct);
                        }}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Type Swithcer</Form.Label>
                    <Form.Select id='productType' onChange={(e) => handleTypeChange(e)}>
                        <option>Book</option>
                        <option>DVD</option>
                        <option>Furniture</option>
                    </Form.Select>
                </Form.Group>
                {typeComponent}
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>There was a problem!</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>{errorMessage}</Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={handleClose}>
                            Close
                        </Button>
                    </Modal.Footer>
                </Modal>
            </Container>
        </Form>
    );
}

export default CreateProduct;