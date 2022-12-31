import axios from 'axios';
import { useEffect, useState } from 'react';
import './ProductsList.css';
import Product from '../Product/Product';
// import Col from 'react-bootstrap/Col';
// import Row from 'react-bootstrap/Row';
import { Navbar, Container, Nav, Col, Row, Button } from 'react-bootstrap';


export default function ProductsList() {
    const [products, setProducts] = useState([]);
    useEffect(() => {
        console.log(products);
    }, [products]);

    const [selected, setSelected] = useState([]);
    useEffect(() => {
        console.log(selected);
    }, [selected]);

    useEffect(() => {
        getProducts();
    }, []);


    function getProducts() {
        axios.get('http://localhost/scandiweb-task/server/index.php').then(function (response) {
            setProducts(response.data);
        });
    }

    const handleDelete = (event) => {
        event.preventDefault();
        selected.forEach(SKU => {
            deleteHelper(SKU);
        });
        // handleSelection({});
    }

    const deleteHelper = (SKU) => {
        let tempSelected = [];
        Object.assign(tempSelected, selected);
        axios.delete('http://localhost/scandiweb-task/server/index.php/' + SKU + '/delete').then(function (response) {
            console.log(response.data);
            tempSelected = tempSelected.filter(product => {
                // eslint-disable-next-line eqeqeq
                return product != SKU;
            });
            setSelected(tempSelected);
            getProducts();
        });
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

    if (products.length === 0) {
        return ([]);
    }

    return (
        <>
            <Navbar bg="dark" variant="dark">
                <Container>
                    <Navbar.Brand>Product List</Navbar.Brand>
                    <Nav variant="pills" activeKey="1" className="me-auto">
                        <Nav.Link className='ADD' style={{ "marginLeft": "20px", "marginRight": "20px" }} eventKey="1" href='/addProduct'>ADD</Nav.Link>
                        <Button style={{ "marginLeft": "20px" }} id='#delete-product-btn' onClick={handleDelete}>MASS DELETE</Button>
                    </Nav>
                </Container>
            </Navbar>
            <Row
                className="g-4">
                {products.map((_, idx) => (
                    <Col key={idx}>
                        <Product
                            product={products[idx]}
                            isSelected={handleSelection}
                        />
                    </Col>
                ))}
            </Row>
        </>
    );
}