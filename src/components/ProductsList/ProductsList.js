import { useEffect, useState } from 'react';
import './ProductsList.css';
import Product from '../Product/Product';
import { Navbar, Container, Nav, Col, Row, Button, Toast, ToastContainer, Modal } from 'react-bootstrap';


export default function ProductsList() {
    const [show, setShow] = useState(false);
    const [errorMessage, setErrorMessage] = useState("");
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);


    const [showToast, setShowToast] = useState(false);

    const [products, setProducts] = useState([]);
    useEffect(() => {
        console.log(products);
    }, [products]);

    const [selected, setSelected] = useState([]);
    useEffect(() => {
        console.log(selected);
    }, [selected]);


    // componentDidMount() {
    //     getProducts();
    // }
    useEffect(() => {
        getProducts();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);


    function getProducts() {
        try {
            fetch(process.env.REACT_APP_BASE_URL, {
                method: 'get',
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                setProducts(data);
            });
        } catch (error) {
            setErrorMessage(error);
            handleShow();
        }
    }

    const handleDelete = (event) => {
        event.preventDefault();
        selected.forEach(SKU => {
            deleteHelper(SKU);
        });
    }

    const deleteHelper = (SKU) => {
        let tempSelected = [];
        Object.assign(tempSelected, selected);
        try {
            fetch(process.env.REACT_APP_DELETE_URL, {
                method: 'post',
                body: JSON.stringify({ "SKU": SKU })
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                console.log(data);
                if (data.status === '200') {
                    tempSelected = tempSelected.filter(product => {
                        // eslint-disable-next-line eqeqeq
                        return product != SKU;
                    })
                    setSelected(tempSelected);
                    getProducts();
                    setShowToast(true);
                }
            });
        } catch (error) {
            setErrorMessage(error);
            handleShow();
        }
    }


    const handleSelection = (data) => {
        let tempSelected = [];
        Object.assign(tempSelected, selected);
        if (data.isChecked) tempSelected.push(data.product);
        else
            tempSelected = tempSelected.filter(product => {
                return product !== data.product;
            });
        setSelected(tempSelected);
    };

    const formatData = (product) => {
        if(product.length && product.width && product.height){
            product.dimensions = `${product.length}x${product.width}x${product.height}`;
            delete product.length;
            delete product.width;
            delete product.height;
        }
        return product;
    }

    return (
        <>
            <Navbar style={{ "marginBottom": "20px" }} bg="dark" variant="dark">
                <Container fluid>
                    <Navbar.Brand>Product List</Navbar.Brand>
                    <Nav variant="pills" activeKey="1" className="justify-content-end">
                        <Nav.Link className='ADD' eventKey="1" href='/addProduct'>ADD</Nav.Link>
                        <Button style={{ "marginLeft": "20px" }} id='delete-product-btn' onClick={handleDelete}>MASS DELETE</Button>
                    </Nav>
                </Container>
            </Navbar>
            <Container fluid>
                <Row
                    className="g-2">
                    {products.map((_, idx) => (
                        <Col
                            xs="auto"
                            sm="auto"
                            md="auto"
                            lg="auto"
                            xl="auto"
                            xxl="auto"
                            key={idx}>
                            <Product
                                product={formatData(products[idx])}
                                isSelected={handleSelection}
                            />
                        </Col>
                    ))}
                </Row>
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
                <ToastContainer className="p-3" position="bottom-center">
                    <Toast onClose={() => setShowToast(false)} show={showToast} delay={3000} autohide>
                        <Toast.Header>
                            <strong className="me-auto">Deleted</strong>
                        </Toast.Header>
                        <Toast.Body>Selected products have been deleted!</Toast.Body>
                    </Toast>
                </ToastContainer>
            </Container>
        </>
    );
}