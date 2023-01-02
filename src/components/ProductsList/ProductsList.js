import { useEffect, useState } from 'react';
import './ProductsList.css';
import Product from '../Product/Product';
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
        try {
            fetch('https://scandiweb-task-marwan-elsheikh.000webhostapp.com/', {
                method: 'get',
            }).then(function (response) {
                return response.json();
            }).then(function (data) {
                // console.log(data);
                setProducts(data);
            });
        } catch (error) {
            alert(error);
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
            fetch('https://scandiweb-task-marwan-elsheikh.000webhostapp.com/deleteproduct/' + SKU, {
                method: 'post',
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
                }
            });
        } catch (error) {
            alert(error);
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